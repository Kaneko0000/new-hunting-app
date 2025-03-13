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
    
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }
    
        $hunters = $query->get();
        // ユーザーが管理者であるかどうかを判定
        $isAdmin = request()->is('admin/*');
    
        return view('hunters.log', compact('hunters', 'prefectures', 'isAdmin'));
    }

    public function create() {
        // dd('create メソッド実行'); 
        $prefectures = config('prefectures');
        $licenses = License::all(); // すべてのライセンスを取得
        return view('hunters.create', compact('prefectures', 'licenses'));
    }

    public function store(Request $request) {
        // フォームからのリクエストデータをログ出力
        Log::info('受け取ったリクエスト:', $request->all());
    
        // バリデーション（失敗時に即リダイレクト）
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hunters,email',
            'phone' => 'required|regex:/^[0-9]{10,11}$/',
            'region' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
            'license_expiry' => 'nullable|date',
            'license_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // 🔥 バリデーションを通過した場合のみ以下の処理を実行 🔥
    
        // ハンター情報を作成
        $hunter = Hunter::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'region' => $validatedData['region'],
            'password' => Hash::make($validatedData['password']),
            'license_expiry' => $validatedData['license_expiry'] ?? null, // 有効期限を保存
        ]);
    
        // ここで保存できているかログ確認
        Log::info('保存後のハンター情報: ', ['hunter' => $hunter]);
    
        // 🔥 免許画像を保存
        if ($request->hasFile('license_image')) {
            $path = $request->file('license_image')->store('licenses', 'public');
            Log::info('画像パス: ', ['path' => $path]);
    
            // `Hunter` に保存
            $hunter->update(['license_image' => $path]);
        }
    
        try {
            Mail::to('vs.noo.moo@gmail.com')->send(new NewHunterNotification($hunter));
            Log::info('メール送信成功: ' . $hunter->email);
        } catch (\Exception $e) {
            Log::error('管理者へのメール送信に失敗: ' . $e->getMessage());
        }
    
        return redirect()->route('hunters.pending')->with('success', '登録申請が完了しました。管理者の承認をお待ちください。');
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

    // 一般ユーザー用のdestroy
    public function destroy(Hunter $hunter)
    {
        $hunter->delete();
        return redirect()->route('hunters.index')->with('success', 'ハンターを削除しました！');
    }

    public function dashboard()
    {
        $hunter = auth()->user();
        return view('hunters.dashboard', compact('hunter'));
    }

}
