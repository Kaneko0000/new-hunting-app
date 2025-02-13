<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // ユーザーがログインしていない場合、ログインページへリダイレクト
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['message' => 'ログインしてください！']);
        }

        // ユーザーの role をチェック
        if (Auth::user()->role !== $role) {
            return redirect('/')->withErrors(['message' => 'アクセス権限がありません。']);
        }

        return $next($request);
    }
}
