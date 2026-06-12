@extends('admin.layouts.app')

@section('title', 'User Profile')
@section('page-title', 'User Profile Details')

@section('content')

    <div class="container-fluid px-4">
        <style>
            :root {
                --primary-dark: #5a1620;
                --primary-medium: #7a202d;
                --primary-light: #9e2a3a;
                --primary-soft: #fdf3e6;
                --primary-bg: #fff8f2;
                --accent-gold: #c9a03d;
                --accent-rose: #e8a0a0;
                --accent-green: #6b8c5c;
                --text-dark: #2d1a1a;
                --text-muted: #8b6b6b;
                --border-light: #f0e0d4;
                --card-shadow: 0 8px 30px rgba(90, 22, 32, 0.08);
                --hover-shadow: 0 12px 40px rgba(90, 22, 32, 0.12);
            }

            body {
                background: var(--primary-bg);
            }

            /* Main Container */
            .profile-container {
                max-width: 1400px;
                margin: 0 auto;
            }

            /* Profile Header */
            .profile-header {
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 50%, var(--primary-light) 100%);
                border-radius: 32px;
                padding: 2rem;
                margin-bottom: 2rem;
                position: relative;
                overflow: hidden;
            }

            .profile-header::before {
                content: '';
                position: absolute;
                top: -30%;
                right: -10%;
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
                border-radius: 50%;
            }

            .profile-header::after {
                content: '';
                position: absolute;
                bottom: -20%;
                left: -5%;
                width: 250px;
                height: 250px;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
                border-radius: 50%;
            }

            .decor-dots {
                position: absolute;
                top: 20px;
                right: 30px;
                display: flex;
                gap: 8px;
            }

            .decor-dots span {
                width: 6px;
                height: 6px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
            }

            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 2rem;
                position: relative;
                z-index: 2;
            }

            .user-main-info {
                display: flex;
                align-items: center;
                gap: 1.8rem;
                flex-wrap: wrap;
            }

            .avatar-wrapper {
                position: relative;
            }

            .avatar-img {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid rgba(255,255,255,0.3);
                box-shadow: 0 15px 35px rgba(0,0,0,0.2);
                transition: transform 0.3s;
            }

            .avatar-img:hover {
                transform: scale(1.02);
            }

            .avatar-badge {
                position: absolute;
                bottom: 5px;
                right: 5px;
                background: var(--accent-gold);
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 3px solid white;
            }

            .user-text h1 {
                font-size: 1.8rem;
                font-weight: 700;
                color: white;
                margin-bottom: 0.25rem;
            }

            .user-text p {
                color: rgba(255,255,255,0.8);
                margin-bottom: 0.75rem;
            }

            .user-meta-icons {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .meta-chip {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 5px 12px;
                background: rgba(255,255,255,0.15);
                border-radius: 30px;
                font-size: 0.7rem;
                color: white;
            }

            /* Header Buttons */
            .header-buttons {
                display: flex;
                gap: 1rem;
            }

            .btn-header-primary {
                background: white;
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 16px;
                color: var(--primary-dark);
                font-weight: 700;
                font-size: 0.85rem;
                transition: all 0.3s;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .btn-header-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            }

            .btn-header-secondary {
                background: rgba(255,255,255,0.2);
                border: 1px solid rgba(255,255,255,0.3);
                padding: 0.75rem 1.5rem;
                border-radius: 16px;
                color: white;
                font-weight: 700;
                font-size: 0.85rem;
                transition: all 0.3s;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .btn-header-secondary:hover {
                background: rgba(255,255,255,0.3);
                transform: translateY(-2px);
            }

            .btn-header-primary:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none;
            }

            /* Stats Row */
            .stats-row {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.25rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                border-radius: 24px;
                padding: 1.25rem;
                box-shadow: var(--card-shadow);
                transition: all 0.3s;
                border: 1px solid var(--border-light);
                position: relative;
                overflow: hidden;
            }

            .stat-card::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, var(--primary-dark), var(--accent-gold));
                transform: scaleX(0);
                transition: transform 0.3s;
            }

            .stat-card:hover::after {
                transform: scaleX(1);
            }

            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: var(--hover-shadow);
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, var(--primary-soft), #f5e6da);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }

            .stat-icon i {
                font-size: 1.25rem;
                color: var(--primary-dark);
            }

            .stat-number {
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--primary-dark);
                margin-bottom: 0.25rem;
            }

            .stat-label {
                font-size: 0.7rem;
                color: var(--text-muted);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Three Column Layout */
            .three-column-layout {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
                margin-bottom: 1.5rem;
            }

            /* Full Width Layout */
            .full-width-layout {
                margin-bottom: 1.5rem;
            }

            /* Cards */
            .info-card {
                background: white;
                border-radius: 24px;
                box-shadow: var(--card-shadow);
                border: 1px solid var(--border-light);
                overflow: hidden;
                transition: all 0.3s;
                height: 100%;
            }

            .info-card:hover {
                box-shadow: var(--hover-shadow);
            }

            .card-header-custom {
                padding: 1.25rem 1.5rem;
                background: var(--primary-soft);
                border-bottom: 1px solid var(--border-light);
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .card-header-custom i {
                font-size: 1.1rem;
                color: var(--primary-dark);
            }

            .card-header-custom h3 {
                font-size: 1rem;
                font-weight: 700;
                color: var(--primary-dark);
                margin: 0;
            }

            .card-body-custom {
                padding: 1.5rem;
            }

            /* Info Rows */
            .info-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.875rem 0;
                border-bottom: 1px solid var(--border-light);
            }

            .info-row:last-child {
                border-bottom: none;
            }

            .info-label {
                font-size: 0.8rem;
                color: var(--text-muted);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .info-value {
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--text-dark);
            }

            /* Location Grid */
            .location-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .location-item {
                text-align: center;
                padding: 1rem;
                background: var(--primary-soft);
                border-radius: 16px;
                transition: all 0.2s;
            }

            .location-item:hover {
                background: #f5e6da;
                transform: translateY(-2px);
            }

            .location-icon {
                font-size: 1.2rem;
                color: var(--primary-dark);
                margin-bottom: 0.5rem;
            }

            .location-label {
                font-size: 0.6rem;
                color: var(--text-muted);
                text-transform: uppercase;
            }

            .location-value {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-top: 0.25rem;
            }

            /* Badges */
            .badge-group {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 1rem;
            }

            .badge-custom {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 16px;
                border-radius: 30px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .badge-primary {
                background: linear-gradient(135deg, var(--primary-dark), var(--primary-medium));
                color: white;
            }

            .badge-soft {
                background: var(--primary-soft);
                color: var(--primary-dark);
            }

            .badge-gold {
                background: var(--accent-gold);
                color: white;
            }

            .badge-rose {
                background: var(--accent-rose);
                color: var(--primary-dark);
            }

            .badge-green {
                background: var(--accent-green);
                color: white;
            }

            /* Verification Status */
            .verification-status {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 16px;
                border-radius: 30px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .verified {
                background: #d4edda;
                color: var(--accent-green);
            }

            .pending {
                background: #fff3cd;
                color: var(--accent-gold);
            }

            /* Preferences Grid - Full Width */
            .pref-grid-full {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1rem;
            }

            .pref-item {
                background: var(--primary-soft);
                padding: 1rem;
                border-radius: 16px;
                transition: all 0.2s;
            }

            .pref-item:hover {
                background: #f5e6da;
                transform: translateY(-3px);
            }

            .pref-key {
                font-size: 0.65rem;
                text-transform: uppercase;
                color: var(--text-muted);
                margin-bottom: 0.5rem;
            }

            .pref-value {
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--text-dark);
            }

            /* Responsive */
            @media (max-width: 1024px) {
                .stats-row {
                    grid-template-columns: repeat(2, 1fr);
                }
                .three-column-layout {
                    grid-template-columns: 1fr;
                }
                .pref-grid-full {
                    grid-template-columns: repeat(2, 1fr);
                }
                .location-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 768px) {
                .stats-row {
                    grid-template-columns: 1fr;
                }
                .header-content {
                    flex-direction: column;
                    text-align: center;
                }
                .user-main-info {
                    flex-direction: column;
                    text-align: center;
                }
                .user-meta-icons {
                    justify-content: center;
                }
                .header-buttons {
                    width: 100%;
                    justify-content: center;
                }
                .pref-grid-full {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="profile-container">
            <!-- Profile Header with Buttons -->
            <div class="profile-header">
                <div class="decor-dots">
                    <span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="header-content">
                    <div class="user-main-info">
                        <div class="avatar-wrapper">
                            <img class="avatar-img" src="{{ $profile->images->first() ? Storage::url($profile->images->first()->file_path) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->name) . '&background=5a1620&color=fff&size=120' }}" alt="Profile">
                            <div class="avatar-badge">
                                <i class="fas fa-check text-white fa-xs"></i>
                            </div>
                        </div>
                        <div class="user-text">
                            <h1>{{ $profile->user->name }}</h1>
                            <p>{{ $profile->user->email }}</p>
                            <div class="user-meta-icons">
                                <span class="meta-chip"><i class="fas fa-id-card"></i> ID #{{ $profile->id }}</span>
                                <span class="meta-chip"><i class="fas fa-calendar"></i> Joined {{ $profile->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="header-buttons">
                        @if($profile->user->status == 'None')
                            <form action="{{ route('admin.profile.changerole', $profile->user_id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-header-primary">
                                    <i class="fas fa-user-shield me-2"></i> Make Admin
                                </button>
                            </form>
                        @else
                            <button class="btn-header-primary" disabled>
                                <i class="fas fa-check-circle me-2"></i> Already Admin
                            </button>
                        @endif
                        <a class="btn-header-secondary" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-arrow-left me-2"></i> Back to Users
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-birthday-cake"></i></div>
                    <div class="stat-number">{{ $profile->age ?? '-' }}</div>
                    <div class="stat-label">Age</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-venus-mars"></i></div>
                    <div class="stat-number">{{ ucfirst($profile->user->gender ?? '-') }}</div>
                    <div class="stat-label">Gender</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-user-tag"></i></div>
                    <div class="stat-number">{{ ucfirst($profile->user->role) }}</div>
                    <div class="stat-label">Role</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-eye"></i></div>
                    <div class="stat-number">{{ ucfirst($profile->visibility) }}</div>
                    <div class="stat-label">Visibility</div>
                </div>
            </div>

            <!-- Three Column Layout for Personal Info, Status, Location -->
            <div class="three-column-layout">
                <!-- Personal Information Card -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="fas fa-user-circle"></i>
                        <h3>Personal Information</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-pray"></i> Religion</span>
                            <span class="info-value">{{ $profile->religion ?? 'Not specified' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-users"></i> Community</span>
                            <span class="info-value">{{ $profile->community ?? 'Not specified' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-heart"></i> Marital Status</span>
                            <span class="info-value text-capitalize">{{ $profile->marital_status ?? 'Not specified' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-briefcase"></i> Profession</span>
                            <span class="info-value">{{ $profile->profession ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status & Badges Card -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="fas fa-medal"></i>
                        <h3>Status & Achievements</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="badge-group">
                            <span class="badge-custom badge-primary"><i class="fas fa-crown"></i> {{ ucfirst($profile->user->role) }}</span>
                            <span class="badge-custom badge-soft"><i class="fas {{ $profile->user->gender == 'male' ? 'fa-mars' : 'fa-venus' }}"></i> {{ ucfirst($profile->user->gender) }}</span>
                            @if ($profile->user->status != 'None')
                                <span class="badge-custom badge-rose"><i class="fas fa-flag"></i> {{ $profile->user->status }}</span>
                            @endif
                            <span class="badge-custom badge-gold"><i class="fas fa-birthday-cake"></i> {{ $profile->age }} Years</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-shield-alt"></i> Verification Status</span>
                            <span class="info-value">
                                @if($profile->verified_by)
                                    <span class="verification-status verified"><i class="fas fa-check-circle"></i> Verified</span>
                                @else
                                    <span class="verification-status pending"><i class="fas fa-clock"></i> Pending</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Location Card -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Location</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="location-grid">
                            <div class="location-item">
                                <div class="location-icon"><i class="fas fa-globe-americas"></i></div>
                                <div class="location-label">Country</div>
                                <div class="location-value">{{ $profile->country ?? 'N/A' }}</div>
                            </div>
                            <div class="location-item">
                                <div class="location-icon"><i class="fas fa-map-pin"></i></div>
                                <div class="location-label">State</div>
                                <div class="location-value">{{ $profile->state ?? 'N/A' }}</div>
                            </div>
                            <div class="location-item">
                                <div class="location-icon"><i class="fas fa-city"></i></div>
                                <div class="location-label">City</div>
                                <div class="location-value">{{ $profile->city ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partner Preferences - Full Width -->
            <div class="full-width-layout">
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="fas fa-heart"></i>
                        <h3>Partner Preferences</h3>
                    </div>
                    <div class="card-body-custom">
                        @php $preferences = $profile->preferences; @endphp
                        @if(is_array($preferences) && !empty($preferences))
                            <div class="pref-grid-full">
                                @foreach($preferences as $key => $value)
                                    @if($value)
                                        <div class="pref-item">
                                            <div class="pref-key">{{ Str::of($key)->replace('_', ' ')->title() }}</div>
                                            <div class="pref-value">{{ is_array($value) ? implode(', ', $value) : $value }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-3 mb-0">No preferences specified yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection