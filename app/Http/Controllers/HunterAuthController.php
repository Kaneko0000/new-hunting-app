<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Hunter;
use Illuminate\Support\Facades\Log; 

class HunterAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('hunters.login'); // loginビューを返す
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        Log::info('ログイン試行: ', $credentials);
        
        $hunter = Hunter::where('email', $request->email)->first();
    
        if (!$hunter) {
            Log::warning('ログイン失敗: ユーザーが見つかりません', ['email' => $request->email]);
            return back()->withErrors(['email' => 'ログイン情報が間違っています。']);
        }
    
        Log::info('ハンター情報: ', ['hunter' => $hunter]);
    
        if (!Hash::check($request->password, $hunter->password)) {
            Log::warning('ログイン失敗: パスワードが不一致', [
                '入力されたパスワード' => $request->password,
                'データベースのパスワード' => $hunter->password
            ]);
            return back()->withErrors(['email' => 'ログイン情報が間違っています。']);
        }
    
        Log::info('パスワードチェック成功: ログイン試行');
    
        // **🔥 承認されているかチェック**
        if ($hunter->status !== 'approved') {
            Log::warning('ログイン拒否: 承認されていないアカウント', ['email' => $request->email]);
            return back()->withErrors(['status' => 'あなたのアカウントはまだ承認されていません。']);
        }
    
        // 🔥 `Auth::guard('hunter')` を使用
        if (Auth::guard('hunter')->attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('ログイン成功: ユーザーID=' . auth()->id());
    
            return redirect()->route('hunters.dashboard'); // ログイン後はハンターダッシュボードへ
        }
    
        Log::warning('ログイン失敗: ', ['email' => $request->email]);
    
        return back()->withErrors([
            'email' => 'ログイン情報が間違っています。',
        ]);
    }
    
    
    

    public function logout()
    {
        Auth::logout();
        return redirect('/hunters/login')->with('success', 'ログアウトしました');
    }
}

