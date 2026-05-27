@component('layouts.guest-layout')
    <style>
        body {
            background: linear-gradient(to bottom right, #fdf3e6, #fbe9d3, #f8d7c4) !important;
        }

        .left-section {
            background: linear-gradient(to bottom right, #7a1f28, #b44a4f) !important;
            color: #fff !important;
        }

        .left-section .icon-check {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            color: #ffd65a !important;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9) !important;
            border-radius: 20px;
            backdrop-filter: blur(6px);
            border: 1px solid #e3c7a0 !important;
        }

        .btn-maroon {
            background-color: #7a1f28 !important;
            color: white !important;
        }

        .btn-maroon:hover {
            background-color: #9d2b34 !important;
        }

        .circle-lg {
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.12) !important;
            border-radius: 50%;
            top: -40px;
            right: -40px;
        }

        .circle-sm {
            position: absolute;
            width: 110px;
            height: 110px;
            background: rgba(255, 255, 255, 0.12) !important;
            border-radius: 50%;
            bottom: -40px;
            left: -40px;
        }
    </style>

    <div class="container vh-100 d-flex justify-content-center align-items-center py-5">

        <div class="row login-card shadow-lg overflow-hidden" style="max-width: 900px; width: 100%;">

            <!-- Left Section -->
            <div class="col-md-6 left-section p-5 d-none d-md-flex flex-column justify-content-center position-relative">

                <h2 class="fw-bold mb-3">Reset Password</h2>
                <p class="mb-4 opacity-75">
                    Don’t worry! We’ll help you get back to finding your perfect match on SoulMate.
                </p>

                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-3">
                        <svg class="icon-check" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Secure password recovery
                    </li>

                    <li class="d-flex align-items-center mb-3">
                        <svg class="icon-check" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Verified email protection
                    </li>

                    <li class="d-flex align-items-center mb-3">
                        <svg class="icon-check" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Quick & easy reset process
                    </li>
                </ul>

                <div class="circle-lg"></div>
                <div class="circle-sm"></div>
            </div>

            <!-- Right Section -->
            <div class="col-md-6 p-5">

                <h3 class="text-center mb-3 fw-bold" style="color:#7a1f28;">
                    Forgot Your Password?
                </h3>

                <p class="text-center mb-4 text-muted">
                    Enter your registered email address and we’ll send you a password reset link.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#7a1f28;">
                            Email Address
                        </label>

                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" autofocus>

                        @error('email')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-maroon w-100 py-2 fw-semibold">
                        Send Password Reset Link
                    </button>

                    <!-- Back to Login -->
                    <p class="text-center mt-4" style="color:#7a1f28;">
                        Remember your password?
                        <a href="{{ route('login') }}" class="fw-semibold" style="color:#7a1f28;">
                            Back to Login
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endcomponent
