<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTerms
{
    public function handle(Request $request, Closure $next)
    {
        $hunter = Auth::guard('hunter')->user(); // 修正
        if (!$hunter->terms_accepted || !$hunter->privacy_accepted) {
            return redirect()->route('terms.show');
        }
        return $next($request);
    }
}
