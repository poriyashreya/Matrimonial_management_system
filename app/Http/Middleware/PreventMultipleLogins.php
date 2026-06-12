<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventMultipleLogins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->session_id !== session()->getId()) {
                auth()->logout();
                return redirect('/login')->with('error', 'Your account logged in from another device.');
            }
        }

        return $next($request);
    }

}
