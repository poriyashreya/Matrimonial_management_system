<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremiumUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->subscribed('default')) {

            return redirect()
                ->route('subscription.plans')
                ->with(
                    'error',
                    'Premium subscription required.'
                );
        }

        return $next($request);
    }
}
