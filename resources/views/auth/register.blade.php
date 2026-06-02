@component('layouts.guest-layout')

    <style>
        /* Page Background Gradient */
        .auth-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #fdf3e6, #fbe9d3, #f8d7c4) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        /* Card Wrapper */
        .auth-card {
            max-width: 1100px;
            width: 100%;
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid #e3c7a0 !important;
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.15) !important;
            overflow: hidden;
        }

        /* Left Gradient Panel */
        .auth-left {
            background: linear-gradient(135deg, #7a1f28, #b44a4f) !important;
            color: white !important;
            padding: 60px !important;
            position: relative !important;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        .auth-left h1 {
            font-size: 38px;
            font-weight: 800;
        }

        .auth-left p {
            font-size: 17px;
            opacity: 0.95;
        }

        /* Decorative Circles */
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

        /* Right Form Section */
        .auth-right {
            padding: 60px 50px !important;
        }

        .auth-title {
            color: #7a1f28 !important;
            font-weight: 800 !important;
            font-size: 32px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form Controls */
        .form-control:focus {
            border-color: #b44a4f !important;
            box-shadow: 0 0 0 0.15rem rgba(180, 74, 79, 0.3) !important;
        }

        /* Button */
        .auth-btn {
            background: #7a1f28 !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 12px 0 !important;
            font-weight: 600 !important;
            transition: 0.3s ease !important;
            width: 100%;
        }

        .auth-btn:hover {
            background: #9d2b34 !important;
        }
    </style>

    <div class="auth-bg">

        <div class="row g-0 auth-card">

            <!-- LEFT PANEL -->
            <div class="col-md-6 d-none d-md-flex flex-column justify-content-center auth-left">

                <h1>Begin Your Journey</h1>
                <p class="mb-4">
                    Join our trusted matrimonial platform to find your perfect life partner.
                    We've successfully connected thousands of couples who are now building their lives together.
                </p>

                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-3">
                        <i class="text-warning me-2 bi bi-check-circle-fill"></i> Verified profiles for security
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="text-warning me-2 bi bi-check-circle-fill"></i> Advanced matching algorithms
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="text-warning me-2 bi bi-check-circle-fill"></i> Privacy-focused platform
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="text-warning me-2 bi bi-check-circle-fill"></i> 24/7 customer support
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="text-warning me-2 bi bi-check-circle-fill"></i> Success stories from happy couples
                    </li>
                </ul>

                <div class="circle-lg"></div>
                <div class="circle-sm"></div>

            </div>

            <!-- RIGHT PANEL -->
            <div class="col-md-6 auth-right">

                <h2 class="auth-title">Matrimonial Registration</h2>

                <div class="text-center mb-4">
                    <img src="{{ asset('images/icon.png') }}" class="img-fluid" style="height: 90px;" alt="">
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label class="fw-semibold text-dark">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="fw-semibold text-dark">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold text-dark">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror"
                            value="{{ old('contact_number') }}">
                        @error('contact_number')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label class="fw-semibold text-dark">Gender</label>
                        <div class="d-flex gap-3 pt-1 flex-wrap">
                            @foreach(['Female', 'Male'] as $status)
                                <label class="pref-chip shadow-sm"
                                    style="background:#f8f9fa; cursor:pointer; border-radius:20px;">
                                    <input type="radio" name="gender" value="{{ $status }}" {{ old('gender') == $status ? 'checked' : '' }} class="@error('gender') is-invalid @enderror"
                                        style="margin-right:5px;">
                                    <span class="fw-semibold text-capitalize text-dark">{{ $status }}</span>
                                </label>
                            @endforeach
                        </div>

                        @error('gender')
                            <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="fw-semibold text-dark">Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="fw-semibold text-dark">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="auth-btn">
                        Register
                    </button>

                    <p class="text-center mt-3">
                        Already have an account?
                        <a href="{{ route('login') }}" class="fw-semibold" style="color:#7a1f28;">Login</a>
                    </p>

                </form>

            </div>

        </div>

    </div>

@endcomponent
