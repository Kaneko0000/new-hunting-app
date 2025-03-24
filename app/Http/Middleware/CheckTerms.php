<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTerms
{
    public function handle(Request $request, Closure $next)
    {
        $hunter = Auth::guard('hunter')->user();

        if (!$hunter) {
          \Log::info('ハンターが取得できませんでした');
          return redirect()->route('hunters.login');
      }

        \Log::info('ハンター情報取得成功', ['hunter' => $hunter]);

        // if (!$hunter->terms_accepted || !$hunter->privacy_accepted) {
        if (!$hunter || !$hunter->terms_accepted || !$hunter->privacy_accepted) {
            return redirect()->route('terms.show');
        }
        return $next($request);
    }
}
