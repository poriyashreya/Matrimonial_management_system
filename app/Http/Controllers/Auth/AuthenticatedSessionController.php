<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display login page
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle normal login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::guard('web')->user();

        if ($user->isAdmin()) {
            Auth::guard('web')->logout();

            // return back()->withErrors([
            //     'email' => 'Please use admin login.',
            // ]);

            return redirect()->route('admin.login');
        }

        if ($user->isUser()) {

        }

        if (!$user->profile) {
            return redirect()->route('profile.create');
        }

        return redirect()->route('dashboard')
            ->with('success', 'You are logged in successfully!');
    }

    /**
     * Logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        return redirect('/');
    }
}





