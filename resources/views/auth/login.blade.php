@component('layouts.guest-layout')

<style>
    body {
        background: linear-gradient(to bottom right, #fdf3e6, #fbe9d3, #f8d7c4);
    }

    .left-section {
        background: linear-gradient(to bottom right, #7a1f28, #b44a4f);
        color: #fff;
    }

    .icon-check {
        width: 18px;
        height: 18px;
        margin-right: 8px;
        color: #ffd65a;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.92);
        border-radius: 20px;
        backdrop-filter: blur(6px);
        border: 1px solid #e3c7a0;
    }

    .btn-maroon {
        background-color: #7a1f28;
        color: white !important;
    }

    .btn-maroon:hover {
        background-color: #9d2b34;
    }

    .circle-lg {
        position: absolute;
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 50%;
        top: -40px;
        right: -40px;
    }

    .circle-sm {
        position: absolute;
        width: 110px;
        height: 110px;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 50%;
        bottom: -40px;
        left: -40px;
    }
</style>

<div class="container vh-100 d-flex justify-content-center align-items-center py-5">

    <div class="row login-card shadow-lg overflow-hidden" style="max-width: 900px; width: 100%;">

        <!-- LEFT SECTION -->
        <div class="col-md-6 left-section p-5 d-none d-md-flex flex-column justify-content-center position-relative">

            <h2 class="fw-bold mb-3">Welcome Back!</h2>
            <p class="mb-4 opacity-75">
                Sign in to continue your journey and reconnect with your potential life partner.
            </p>

            <ul class="list-unstyled">
                <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-check-circle-fill icon-check"></i>
                    Secure & verified accounts
                </li>
                <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-check-circle-fill icon-check"></i>
                    Privacy-focused platform
                </li>
                <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-check-circle-fill icon-check"></i>
                    24/7 support & guidance
                </li>
            </ul>

            <div class="circle-lg"></div>
            <div class="circle-sm"></div>
        </div>

        <!-- RIGHT SECTION -->
        <div class="col-md-6 p-5">

            <h2 class="text-center mb-4 fw-bold" style="color:#7a1f28;">
                Login to Your Account
            </h2>

            <!-- Session Messages -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:#7a1f28;">
                        Email Address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror">

                    @error('email')
                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:#7a1f28;">
                        Password
                    </label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

                    @error('password')
                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="mb-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="color:#7a1f28;">
                            Forgot your password?
                        </a>
                    </div>
                @endif

                <!-- Submit -->
                <button type="submit" class="btn btn-maroon w-100 py-2 fw-semibold">
                    Log In
                </button>

                <!-- Register -->
                <p class="text-center mt-3" style="color:#7a1f28;">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="fw-semibold" style="color:#7a1f28;">
                        Register
                    </a>
                </p>
            </form>

        </div>
    </div>
</div>

@endcomponent