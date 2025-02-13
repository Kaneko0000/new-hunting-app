<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hunter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\HunterRequest;
use App\Models\License;




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
        $prefectures = config('prefectures');
        $licenses = License::all(); // すべてのライセンスを取得
        return view('hunters.create', compact('prefectures', 'licenses'));
    }

    public function store(Request $request)
    {
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

        // 管理者へ通知
        Mail::to('admin@example.com')->send(new NewHunterNotification($hunter));


        // 免許の登録（多対多の関係）
        if ($request->has('licenses')) {
            foreach ($request->licenses as $license_id) {
                $hunter->licenses()->attach((int)$license_id, [  // ここで整数にキャスト
                    'license_image' => $request->file('license_image') ? $request->file('license_image')->store('licenses', 'public') : null,
                    'license_expiry' => $request->license_expiry,
                ]);
            }
        }
        return redirect()->route('hunters.index')->with('success', 'ハンターを登録しました！');
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
