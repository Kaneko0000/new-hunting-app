<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Hunter;

class HunterAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('hunters.login'); // loginビューを返す
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // **管理者なら管理者ダッシュボードへ、ハンターならハンターダッシュボードへ**
            return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'hunters.dashboard');
        }
    
        return back()->withErrors(['email' => 'ログイン情報が正しくありません']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/hunters/login')->with('success', 'ログアウトしました');
    }
}

