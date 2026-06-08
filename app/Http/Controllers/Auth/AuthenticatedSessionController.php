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
        // Authenticate user
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();

        $user = auth()->user();

        // Check profile exists
        $profileExists = Profile::where('user_id', $user->id)->exists();

        if ($user->isAdmin()) {
            // Redirect to admin password page
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Welcom! To Admin dashboard');
        }

        /**
         * NORMAL USER FLOW
         */ elseif ($user->isUser()) {

            // If profile not created
            if (!auth()->user()->profile) {
                return redirect()->route('profile.create');
            }

            return redirect()->route('dashboard')
                ->with('success', 'You are logged in successfully!');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Show admin password page
     */
    public function showAdminPasswordForm(): View
    {
        return view('admin.auth.admin-password');
    }

    /**
     * Verify admin dashboard password
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required'
        ]);

        // Get admin id from session
        $userId = session('admin_user_id');

        // Find user
        $user = User::find($userId);

        // If no user found
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        // Initialize attempts
        if (!session()->has('admin_password_attempts')) {
            session([
                'admin_password_attempts' => 0
            ]);
        }

        dump($user);

        // Rate limiting key

        /**
         * WRONG PASSWORD
         */
        if (!Hash::check($request->password, $user->admin_dashboard_password)) {

            // Increase attempts
            $attempts = session('admin_password_attempts') + 1;

            session([
                'admin_password_attempts' => $attempts
            ]);

            // Maximum attempts reached
            if ($attempts >= 3) {

                session()->forget([
                    'admin_user_id',
                    'admin_password_attempts'
                ]);


                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'updated_at' => now()
                    ]);

                return redirect()->route('login')
                    ->with(
                        'error',
                        'Too many incorrect admin password attempts. Please login again.'
                    );

                RateLimiter::hit($key, 60); // lock for 60 seconds
            }

            // Remaining attempts
            $remaining = 3 - $attempts;

            return back()->with(
                'error',
                "Invalid admin dashboard password. {$remaining} attempt(s) remaining."
            );
        }

        /**
         * CORRECT PASSWORD
         */

        // Login admin
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Clear temp session data
        session()->forget([
            'admin_user_id',
            'admin_password_attempts'
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome to Admin Dashboard!');
    }

    /**
     * Logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}