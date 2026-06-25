<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class TabAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Auth-Token');

        if (!$token) {
            return redirect()->route('login');
        }

        $session = UserSession::where('token', $token)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$session) {
            return redirect()->route('login');
        }

        Auth::loginUsingId($session->user_id);

        return $next($request);
    }
}