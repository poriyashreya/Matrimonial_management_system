@extends('layouts.app')

@section('content')

    <section class="settings-glass">
        <div class="glass-layout">

            <!-- SIDEBAR -->
            <div class="glass-sidebar">
                <button type="button" class="tab-btn active" onclick="openTab(event,'profile')">
                    👤 Profile
                </button>

                <button type="button" class="tab-btn" onclick="openTab(event,'security')">
                    🔒 Security
                </button>

                <button type="button" class="tab-btn danger" onclick="openTab(event,'danger')">
                    ⚠ Delete
                </button>
            </div>

            <!-- CONTENT -->
            <div class="glass-content">

                <div class="glass-header text-center">
                    <h2>Account Settings</h2>
                    <p>Manage profile, security & account controls</p>
                </div>


                <!-- SUCCESS MESSAGE -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <!-- PROFILE -->
                <div id="profile" class="tab-content active">
                    <h4>Profile Information</h4>

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf

                        <div class="floating-input">
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required placeholder=" ">
                            <label>Username</label>
                        </div>

                        <div class="floating-input">
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required placeholder=" ">
                            <label>Email Address</label>
                        </div>

                        <button class="btn primary-btn">Save Changes</button>
                    </form>
                </div>

                <!-- SECURITY -->
                <div id="security" class="tab-content">
                    <h4>Change Password</h4>

                    <form method="POST" action="{{ route('settings.password') }}">
                        @csrf

                        <!-- Password -->
                        <div class="floating-input">
                            <input type="password" name="password"
                                class="form-control {{ session('error') ? 'is-invalid' : '' }}" required>
                            <label>Password</label>
                            @if(session('error'))
                                <div class="invalid-feedback fw-bold">{{ session('error') }}</div>
                            @endif
                            <!-- @error('password')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror -->
                        </div>

                        <!-- Confirm Password -->
                        <div class="floating-input">
                            <input type="password" name="password_confirmation" class="form-control" required>
                            <label>Confirm Password</label>
                        </div>

                        <button class="btn outline-btn">Update Password</button>
                    </form>
                </div>

                <!-- DELETE -->
                <div id="danger" class="tab-content">
                    <div class="delete-card text-center">

                        <div class="delete-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                        <h4>Delete User Account</h4>
                        <p>This action is permanent and cannot be undone.</p>

                        <!-- Password Check -->
                        <div class="floating-input">
                            <input type="password" name="delete-password" id="deletePassword" required placeholder="">
                            <label>Enter Password</label>
                            <div class="invalid-feedback d-block fw-bold" id="passwordError"></div>
                        </div>

                        <button class="btn delete-btn" onclick="verifyPassword()">
                            Continue
                        </button>

                        <button class="btn cancel-btn" onclick="openTab(event,'profile')">
                            Cancel
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CONFIRM DELETE MODAL -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-modal">

                <div class="modal-body text-center">
                    <div class="delete-icon mb-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <h5 class="text-danger fw-bold">Are you absolutely sure?</h5>
                    <p class="text-muted small">
                        This will permanently delete your account.
                    </p>

                    <form method="POST" action="{{ route('settings.delete') }}">
                        @csrf
                        <input type="hidden" name="password" id="confirmedPassword">

                        <button type="submit" class="btn delete-btn w-100">
                            Yes, Delete My Account
                        </button>

                        <button type="button" class="btn cancel-btn w-100 mt-2" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Auto-open modal if backend error --}}
    @if(session('openDeleteModal'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
            });
        </script>
    @endif

    <script>
        function openTab(evt, tabId) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

            document.getElementById(tabId).classList.add('active');
            evt.currentTarget.classList.add('active');
        }

        function verifyPassword() {
            const passwordInput = document.getElementById('deletePassword');
            const password = passwordInput.value.trim();
            const error = document.getElementById('passwordError');

            error.innerText = '';
            passwordInput.classList.remove('is-invalid');

            if (password === '') {
                error.innerText = 'Password is required to continue.';
                passwordInput.classList.add('is-invalid');
                return;
            }

            fetch("{{ route('settings.checkPassword') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ password })
            })
                .then(res => {
                    if (!res.ok) throw res;
                    return res.json();
                })
                .then(() => {
                    document.getElementById('confirmedPassword').value = password;
                    new bootstrap.Modal(
                        document.getElementById('deleteConfirmModal')
                    ).show();
                })
                .catch(async err => {
                    const data = await err.json();
                    error.innerText = data.message || 'Incorrect password.';
                    passwordInput.classList.add('is-invalid');
                });
        }


        document.addEventListener("DOMContentLoaded", function () {

            // Set active tab from session or default
            let activeTab = 'profile';
            @if(session('activeTab'))
                activeTab = '{{ session('activeTab') }}';
            @endif

            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

            document.getElementById(activeTab)?.classList.add('active');
            document.querySelector(`.tab-btn[onclick*="${activeTab}"]`)?.classList.add('active');

        });
    </script>
@endsection