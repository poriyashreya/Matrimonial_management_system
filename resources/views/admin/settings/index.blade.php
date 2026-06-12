@extends('admin.layouts.app')

@section('content')
    <div class="settings-wrapper">

        <h2 class="settings-title">⚙️ Display & Admin Settings</h2>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <!-- Admin Details -->
            <div class="settings-card">
                <h4>👑 Admin Information</h4>

                <div class="input-group">
                    <label>Admin Name</label>
                    <input type="text" name="name" value="{{ $admin->name }}">
                </div>

                <div class="input-group">
                    <label>Admin Email</label>
                    <input type="email" name="email" value="{{ $admin->email }}" readonly>
                </div>

                <div class="info-row">
                    <span>Role:</span>
                    <span class="badge">{{ ucfirst($admin->role) }}</span>
                </div>
            </div>


            <!-- General Details (Read Only Example) -->
            <div class="settings-card">
                <h4>🌐 General System Info</h4>

                <div class="info-row">
                    <span>Total Users</span>
                    <strong>{{ \App\Models\User::count() }}</strong>
                </div>

                <div class="info-row">
                    <span>Premium Users</span>
                    <strong>{{ \App\Models\User::where('role', 'Premium')->count() }}</strong>
                </div>

                <div class="info-row">
                    <span>Pro Users</span>
                    <strong>{{ \App\Models\User::where('role', 'Pro')->count() }}</strong>
                </div>

                <div class="info-row">
                    <span>Free Users</span>
                    <strong>{{ \App\Models\User::where('role', 'free')->count() }}</strong>
                </div>
            </div>

            <button type="submit" class="save-btn">💾 Save Changes</button>
        </form>

    </div>

    <script>
        window.flashData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
        };
    </script>

@endsection