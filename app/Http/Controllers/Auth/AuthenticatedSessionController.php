<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Profile;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // Check if the user has a profile
        $profileExists = Profile::where('user_id', $user->id)->exists();

        // If profile exists, redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome to the admin dashboard!');
        } elseif ($user->isUser()) {
            if (!$profileExists) {
                // If profile does not exist, redirect to create profile page
                return redirect()->route('profile.create');
            }
            return redirect()->route('dashboard')
                ->with('success', 'You are logged in successfully!');
        }

        return redirect()->route('dashboard');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
