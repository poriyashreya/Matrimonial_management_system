<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminPasswordController extends Controller
{
    public function showForm()
    {
        return view('admin.auth.admin-password');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $userId = session('admin_user_id');

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        // Initialize attempts
        if (!session()->has('admin_password_attempts')) {
            session([
                'admin_password_attempts' => 0
            ]);
        }

        /**
         * WRONG PASSWORD
         */
        /**
         * WRONG PASSWORD
         */
        if ($request->password !== "Admin@2026") {

            $attempts = session('admin_password_attempts') + 1;

            session([
                'admin_password_attempts' => $attempts
            ]);

            // Max attempts reached
            if ($attempts >= 3) {

                session()->forget([
                    'admin_user_id',
                    'admin_password_attempts'
                ]);

                return redirect()->route('login')
                    ->with(
                        'error',
                        'Too many incorrect admin password attempts. Please login again.'
                    );
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

        // Clear temp session
        session()->forget([
            'admin_user_id',
            'admin_password_attempts'
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome Admin!');
    }
}