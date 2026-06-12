{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="profile-app">

        <!-- HERO SECTION - Enhanced -->
        <div class="hero-section">
            <div class="hero-bg-pattern"></div>
            <div class="hero-container">
                <div class="hero-left">
                    <div class="avatar-wrapper">
                        <div class="avatar-ring"></div>
                        <img src="{{ $profile->images->first() ? Storage::url($profile->images->first()->file_path) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->name) . '&background=7a1f28&color=fff&size=100' }}"
                            class="hero-avatar">
                    </div>
                    <div class="hero-info">
                        <div class="hero-greeting">
                            <span class="greeting-badge">Welcome back,</span>
                            <h1>{{ $profile->user->name }}</h1>
                        </div>
                        <p class="hero-profession">{{ $profile->profession ?? 'Update your profession' }}</p>
                        <div class="hero-meta">
                            <span class="meta-chip"><i class="fas fa-calendar-alt"></i> {{ $profile->age }} years</span>
                            <span class="meta-chip"><i class="fas fa-ring"></i>
                                {{ ucfirst($profile->marital_status) }}</span>
                            <span class="meta-chip"><i class="fas fa-map-marker-alt"></i>
                                {{ $profile->country ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                <div class="hero-right">
                    <a href="{{ route('profile.edit') }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>



                    @if(strtolower($profile->plan) == 'none' || strtolower($profile->plan) == 'free' || strtolower($profile->plan) == 'premium')
                        <a href="{{ route('plans') }}" class="btn-premium">
                            <i class="fas fa-gem"></i> Upgrade
                        </a>
                    @endif

                    @if(strtolower($profile->plan) !== "free" && strtolower($profile->plan) !== "none")
                        <form action="{{ route('subscription.cancel') }}" method="POST" id="cancelSubscriptionForm">

                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn-cancel1" onclick="confirmCancel()">
                                <i class="fas fa-times-circle"></i> Cancel Subscription
                            </button>

                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- LAYOUT -->
        <div class="profile-layout">

            <!-- SIDEBAR - Enhanced -->
            <aside class="profile-sidebar">
                <!-- Membership Badge -->
                <div class="membership-card">
                    @if($profile->plan === 'Premium')
                        <div class="badge premium">
                            <i class="fas fa-crown"></i> Premium Member
                            <span class="badge-icon">⭐</span>
                        </div>
                    @elseif($profile->plan === 'Pro')
                        <div class="badge pro">
                            <i class="fas fa-star"></i> Pro Member
                        </div>
                    @else
                        <div class="badge free">
                            <i class="fas fa-user"></i> Free Member
                        </div>
                    @endif
                </div>

                <!-- Contact Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-address-book"></i>
                        <h3>Contact Information</h3>
                    </div>
                    <div class="contact-list">
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div class="contact-detail">
                                <span class="contact-label">Email</span>
                                <span class="contact-value">{{ $profile->user->email }}</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="contact-detail">
                                <span class="contact-label">Phone</span>
                                <span class="contact-value">{{ $profile->user->contact_number ?? 'Not added' }}</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="contact-detail">
                                <span class="contact-label">Member Since</span>
                                <span class="contact-value">{{ $profile->created_at->format('F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="card action-card">
                    <a href="{{ route('profile.verification') }}" class="action-btn verify-btn">
                        <i class="fas fa-shield-alt"></i> Verify Account
                    </a>

                    @if(strtolower($profile->plan) !== 'free' && strtolower($profile->plan) !== 'none')
                        <a href="{{ route('matches.show') }}" class="action-btn browse-btn">
                            <i class="fas fa-search"></i> Browse Matches
                        </a>
                    @endif
                    <a href="{{ route('profile.deleteform') }}" class="action-btn delete-btn">
                        <i class="fas fa-trash-alt"></i> Delete Account
                    </a>
                </div>
            </aside>

            <!-- MAIN CONTENT - Enhanced -->
            <main class="profile-main">

                <!-- TABS - Modern Design -->
                <div class="tabs-container">
                    <div class="tabs">
                        <button class="tab active" data-tab="personal">
                            <i class="fas fa-user-circle"></i>
                            <span>Personal Info</span>
                        </button>
                        <button class="tab" data-tab="location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Location</span>
                        </button>
                        <button class="tab" data-tab="preferences">
                            <i class="fas fa-heart"></i>
                            <span>Preferences</span>
                        </button>
                    </div>
                </div>

                <!-- PERSONAL PANEL -->
                <div class="panel active" id="personal">
                    <div class="panel-header">
                        <h2><i class="fas fa-address-card"></i> Personal Information</h2>
                    </div>
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-user"></i></div>
                            <div class="info-content">
                                <span class="info-label">Full Name</span>
                                <span class="info-value">{{ $profile->user->name }}</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                            <div class="info-content">
                                <span class="info-label">Gender</span>
                                <span class="info-value">{{ ucfirst($profile->user->gender) }}</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-birthday-cake"></i></div>
                            <div class="info-content">
                                <span class="info-label">Age</span>
                                <span class="info-value">{{ $profile->age }} years</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-ring"></i></div>
                            <div class="info-content">
                                <span class="info-label">Marital Status</span>
                                <span class="info-value">{{ ucfirst($profile->marital_status) }}</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-pray"></i></div>
                            <div class="info-content">
                                <span class="info-label">Religion</span>
                                <span class="info-value">{{ $profile->religion ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-users"></i></div>
                            <div class="info-content">
                                <span class="info-label">Community</span>
                                <span class="info-value">{{ $profile->community ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-briefcase"></i></div>
                            <div class="info-content">
                                <span class="info-label">Profession</span>
                                <span class="info-value">{{ $profile->profession ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-graduation-cap"></i></div>
                            <div class="info-content">
                                <span class="info-label">Education</span>
                                <span class="info-value">{{ $profile->education ?? 'Not specified' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LOCATION PANEL -->
                <div class="panel" id="location">
                    <div class="panel-header">
                        <h2><i class="fas fa-map-pin"></i> Location & Details</h2>
                    </div>
                    <div class="location-grid">
                        <div class="location-card">
                            <div class="location-icon"><i class="fas fa-globe-americas"></i></div>
                            <div class="location-info">
                                <span class="location-label">Country</span>
                                <span class="location-value">{{ $profile->country ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="location-card">
                            <div class="location-icon"><i class="fas fa-city"></i></div>
                            <div class="location-info">
                                <span class="location-label">State</span>
                                <span class="location-value">{{ $profile->state ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="location-card">
                            <div class="location-icon"><i class="fas fa-building"></i></div>
                            <div class="location-info">
                                <span class="location-label">City</span>
                                <span class="location-value">{{ $profile->city ?? 'Not specified' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PREFERENCES PANEL -->
                <div class="panel" id="preferences">
                    <div class="panel-header">
                        <h2><i class="fas fa-heart"></i> Partner Preferences</h2>
                    </div>

                    @php
                        $prefs = is_array($profile->preferences)
                            ? $profile->preferences
                            : json_decode($profile->preferences, true);
                        $prefs = $prefs ?? [];
                    @endphp

                    @if(!empty($prefs))
                        <div class="preferences-grid">
                            @if(!empty($prefs['age_min']) || !empty($prefs['age_max']))
                                <div class="pref-card">
                                    <div class="pref-icon"><i class="fas fa-calendar-alt"></i></div>
                                    <div class="pref-content">
                                        <span class="pref-label">Age Range</span>
                                        <span class="pref-value">{{ $prefs['age_min'] ?? 'Any' }} - {{ $prefs['age_max'] ?? 'Any' }}
                                            years</span>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($prefs['religion']))
                                <div class="pref-card">
                                    <div class="pref-icon"><i class="fas fa-pray"></i></div>
                                    <div class="pref-content">
                                        <span class="pref-label">Religion</span>
                                        <span class="pref-value">{{ $prefs['religion'] }}</span>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($prefs['Cast']))
                                <div class="pref-card">
                                    <div class="pref-icon"><i class="fas fa-users"></i></div>
                                    <div class="pref-content">
                                        <span class="pref-label">Caste / Community</span>
                                        <span class="pref-value">{{ $prefs['Cast'] }}</span>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($prefs['marital_status']))
                                <div class="pref-card">
                                    <div class="pref-icon"><i class="fas fa-ring"></i></div>
                                    <div class="pref-content">
                                        <span class="pref-label">Marital Status</span>
                                        <div class="pref-tags">
                                            @foreach($prefs['marital_status'] as $status)
                                                <span class="tag">{{ $status }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($prefs['profession']))
                                <div class="pref-card ">
                                    <div class="pref-icon"><i class="fas fa-briefcase"></i></div>
                                    <div class="pref-content">
                                        <span class="pref-label">Profession</span>
                                        <div class="pref-tags">
                                            @foreach($prefs['profession'] as $prof)
                                                <span class="tag">{{ $prof }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="loca-grid">
                            @if(!empty($prefs['location']))
                                <div class="pref-card w-100">
                                    <div class="pref-icon"><i class="fas fa-map-marker-alt"></i></div>
                                    <div class="pref-content">
                                        <span class="pref-label">Preferred Locations</span>
                                        <div class="pref-tags">
                                            @foreach($prefs['location'] as $loc)
                                                <span class="tag">{{ $loc }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($prefs['personality']))
                                <div class="pref-card">
                                    <div class="pref-icon"><i class="fas fa-smile"></i></div>
                                    <div class="pref-content">
                                        <span class="pref-label">Personality Traits</span>
                                        <div class="pref-tags">
                                            @foreach($prefs['personality'] as $trait)
                                                <span class="tag personality">{{ $trait }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-heart-broken"></i>
                            <p>You haven't set any partner preferences yet</p>
                            <a href="{{ route('profile.edit') }}" class="btn-add">
                                <i class="fas fa-plus"></i> Add Preferences
                            </a>
                        </div>
                    @endif

                    <!-- Upgrade Banner for Free Users -->
                    @if($profile->plan === 'Free' || $profile->plan === 'free')
                        <div class="upgrade-banner">
                            <div class="banner-content">
                                <i class="fas fa-crown"></i>
                                <div>
                                    <h4>Unlock Premium Features</h4>
                                    <p>Get more visibility, see who viewed you, and send unlimited interests</p>
                                </div>
                            </div>
                            <a href="{{ route('plans') }}" class="btn-upgrade">
                                Upgrade Now <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));

                tab.classList.add('active');
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>

    <script>
        function confirmCancel() {
            Swal.fire({
                title: 'Cancel Subscription?',
                text: "Your subscription will be cancelled and premium access may stop.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7a1f28',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Cancel It',
                cancelButtonText: 'Keep Subscription'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelSubscriptionForm').submit();
                }
            });
        }
    </script>

    <script>
        window.flashData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
        };
    </script>

@endsection