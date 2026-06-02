@component('layouts.guest-layout')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #fdf3e6 0%, #fbe9d3 50%, #f8d7c4 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Animated background shapes */
    .bg-shapes {
        position: fixed;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
    }

    .shape {
        position: absolute;
        background: rgba(122, 31, 40, 0.05);
        border-radius: 50%;
        animation: float 20s infinite ease-in-out;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        top: -150px;
        right: -150px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        bottom: -100px;
        left: -100px;
        animation-delay: 5s;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 20%;
        animation-delay: 10s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(5deg);
        }
    }

    .container {
        position: relative;
        z-index: 1;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    /* Two Column Layout */
    .auth-wrapper {
        max-width: 1000px;
        width: 100%;
        background: white;
        border-radius: 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Left Column - Welcome Section */
    .welcome-section {
        flex: 1;
        background: linear-gradient(135deg, #7a1f28 0%, #9e3a42 50%, #b44a4f 100%);
        padding: 3rem;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .brand-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        font-size: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .welcome-section h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .welcome-section p {
        font-size: 1rem;
        line-height: 1.6;
        opacity: 0.95;
        margin-bottom: 2rem;
    }

    .feature-list {
        list-style: none;
        margin-top: 1rem;
    }

    .feature-list li {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
    }

    .feature-list li i {
        width: 24px;
        font-size: 1.1rem;
        opacity: 0.9;
        color: white;
    }

    /* Right Column - Login Section */
    .login-section {
        flex: 1;
        padding: 3rem;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .login-header h2 {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Alert Styles */
    .alert-custom {
        border-radius: 12px;
        padding: 0.875rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    .alert-danger {
        background: #fee2e2;
        border-left: 4px solid #7a1f28;
        color: #991b1b;
    }

    .alert-danger i {
        color: #7a1f28;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        color: #c97a7a;
        font-size: 1rem;
        z-index: 10;
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .input-group:focus-within .input-icon {
        color: #b44a4f;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid #f0d6d6;
        font-size: 0.9375rem;
        border-radius: 12px !important;
        background: white;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus {
        outline: none;
        border-color: #b44a4f;
        box-shadow: 0 0 0 3px rgba(180, 74, 79, 0.1);
    }

    /* Password Toggle Button */
    .password-toggle {
        position: absolute;
        right: 1rem;
        background: none;
        border: none;
        color: #c97a7a;
        cursor: pointer;
        font-size: 1rem;
        transition: color 0.3s ease;
        z-index: 10;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-toggle:hover {
        color: #7a1f28;
    }

    /* Button */
    .btn-login {
        width: 100%;
        padding: 0.875rem;
        background: #7a1f28;
        color: white !important;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .btn-login:hover {
        background: #9e3a42;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(122, 31, 40, 0.4);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .auth-wrapper {
            flex-direction: column;
            max-width: 450px;
        }

        .welcome-section {
            padding: 2rem;
            text-align: center;
        }

        .welcome-section h1 {
            font-size: 2rem;
        }

        .brand-icon {
            margin: 0 auto 1.5rem;
        }

        .feature-list {
            text-align: left;
            max-width: 280px;
            margin: 0 auto;
        }

        .login-section {
            padding: 2rem;
        }

        .login-header h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 1rem;
        }

        .welcome-section {
            padding: 1.5rem;
        }

        .welcome-section h1 {
            font-size: 1.5rem;
        }

        .login-section {
            padding: 1.5rem;
        }
    }
</style>
</head>

<body>

    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container">
        <div class="auth-wrapper">
            <!-- Left Column - Welcome Section -->
            <div class="welcome-section">
                <div class="brand-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1>Welcome Back!</h1>
                <p>Verify your credentials to access the admin dashboard and manage your platform securely.</p>

                <ul class="feature-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Secure & encrypted access</span>
                    </li>
                    <li>
                        <i class="fas fa-shield-alt"></i>
                        <span>Role-based permissions</span>
                    </li>
                    <li>
                        <i class="fas fa-chart-line"></i>
                        <span>Real-time analytics dashboard</span>
                    </li>
                    <li>
                        <i class="fas fa-headset"></i>
                        <span>24/7 administrative support</span>
                    </li>
                </ul>
            </div>

            <!-- Right Column - Login Section -->
            <div class="login-section">
                <div class="login-header">
                    <h2>Admin Access</h2>
                    <p>Enter your security credentials to continue</p>
                </div>

                @if(session('error'))
                    <div class="alert-custom alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.password.verify') }}" id="adminForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Security Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Enter your password" required autocomplete="current-password" autofocus>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="far fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login mt-5" id="submitBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Verify & Access</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye-slash');
                icon.classList.toggle('fa-eye');
            });
        }

        // Form submission animation
        const form = document.getElementById('adminForm');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
                submitBtn.disabled = true;

                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalHtml;
                        submitBtn.disabled = false;
                    }
                }, 8000);
            });
        }
    </script>
</body>
@endcomponent