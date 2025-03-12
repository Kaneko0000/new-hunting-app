<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        // return view('admin.hunters.index'); // 管理者用ログイン画面
        return view('admin.login'); // 管理者用ログイン画面
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('管理者ログイン試行: ', $credentials);

        // 🔥 `users` テーブルを使うようにする
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('管理者ログイン成功: ' . auth('admin')->id());

            return redirect()->route('admin.dashboard');
            // return redirect()->intended(route('admin.hunters.index'));

        }

        Log::warning('管理者ログイン失敗: ', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'ログイン情報が間違っています。',
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login')->with('success', 'ログアウトしました');
    }
}
