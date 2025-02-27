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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return auth()->user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('hunters.dashboard');
        }
    
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

