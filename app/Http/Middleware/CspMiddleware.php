<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CspMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // `frame-ancestors` に JMA (気象庁) を追加
        $response->headers->set('Content-Security-Policy', "frame-ancestors 'self' https://www.jma.go.jp");

        return $response;
    }
}
