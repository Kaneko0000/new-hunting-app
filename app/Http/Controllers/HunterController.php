<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hunter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\HunterRequest;
use App\Models\License;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewHunterNotification;
use Illuminate\Support\Facades\Log;




class HunterController extends Controller
{
    public function index(Request $request)
    {
        $query = Hunter::with('licenses');
        $prefectures = config('prefectures');

        if($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->filled('region')) {
            $query->where('region', $request->region);
        }

        $hunters = $query->get();
        return view('hunters.index', compact('hunters', 'prefectures'));
    }

    public function create() {
        // dd('create メソッド実行'); 
        $prefectures = config('prefectures');
        $licenses = License::all(); // すべてのライセンスを取得
        return view('hunters.create', compact('prefectures', 'licenses'));
    }

    public function store(HunterRequest $request) {
        // dd('store メソッド実行'); // ここで一度処理が止まるはず
        dd($request->all()); // フォームから送信されたデータを全表示
        // ハンター情報を作成
        $hunter = Hunter::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'region' => $request->region,
            'password' => Hash::make($request->password), // パスワードをハッシュ化
            'status' => 'pending',
        ]);

        // 免許画像の保存
        if ($request->hasFile('license_image')) {
            $path = $request->file('license_image')->store('licenses', 'public');
            $hunter->update(['license_image' => $path]);
        }

        // **ここで $hunter が null ではないか確認**
        Log::info('新規ハンター登録: ', ['hunter' => $hunter]);

        // 管理者へ通知（エラーハンドリング追加）
        try {
            // Mail::fake(); // 本番環境で送信せずにテストする
            Mail::to('vs.noo.moo@gmail.com')->send(new NewHunterNotification($hunter));
            // Mail::to('vs.noo.moo@gmail.com')->send(new \App\Mail\NewHunterNotification($hunter));
            Log::info('メール送信成功: ' . $hunter->email);
        } catch (\Exception $e) {
            Log::error('管理者へのメール送信に失敗: ' . $e->getMessage());
        }

        // 免許の登録（多対多の関係）
        if ($request->has('licenses')) {
            foreach ($request->licenses as $license_id) {
                $hunter->licenses()->attach((int)$license_id, [  // ここで整数にキャスト
                    'license_image' => $hunter->license_image, // すでに保存済みの画像パスを使用
                    'license_expiry' => $request->license_expiry,
                ]);
            }
        }

        // 登録完了後のリダイレクト
        // return redirect()->route('hunters.index')->with('success', '登録申請が完了しました。管理者の承認をお待ちください。');
        return redirect('/')->with('success', '登録申請が完了しました。管理者の承認をお待ちください。');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Hunter $hunter)
    {
        $prefectures = config('prefectures');
        $licenses = License::all();

        // ハンターの免許IDを配列として取得（編集画面でチェックをつけるため）
        $hunterLicenses = $hunter->licenses->pluck('id')->toArray();

        return view('hunters.edit', compact('hunter', 'prefectures', 'licenses', 'hunterLicenses'));
    }

    public function update(HunterRequest $request, Hunter $hunter)
    {
        $hunter->update($request->validated());

        // 免許の更新（多対多の同期）
        if ($request->has('licenses')) {
            $hunter->licenses()->sync($request->licenses);
        } else {
            $hunter->licenses()->detach(); // 免許が選択されていない場合は全て解除
        }
        
        return redirect()->route('hunters.index')->with('success', 'ハンター情報を更新しました！');
    }

    public function destroy(Hunter $hunter)
    {
        $hunter->delete();
        return redirect()->route('hunters.index')->with('success', 'ハンターを削除しました！');
    }

    public function approve($id)
    {
        $hunter = Hunter::findOrFail($id);
        $hunter->status = 'approved';  // ステータスを 'approved' に変更
        $hunter->save();

        return redirect()->route('hunters.index')->with('success', 'ハンターが承認されました。');
    }

}
