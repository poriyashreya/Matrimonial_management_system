<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('web')->check()) {
            return redirect()->route('login');
        }

        if (strtolower(auth('web')->user()->role) !== 'user') {
            abort(403);
        }

        return $next($request);
    }
}