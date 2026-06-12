{{-- resources/views/profiles/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="profile-show-container container">

        <!-- Header with Elegant Burgundy Theme -->
        <div class="edit-header mb-5 text-center">
            <div class="row">
                <div class="col-5 text-end">
                    <div class="profile-header-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
                <div class="col-7 text-start">
                    <h2 class=" profile-header-title animate-slide-down">Profile Details</h2>
                    <p class="profile-header-subtitle animate-slide-down delay-1">
                        <i class="fas fa-heart me-1"></i> Discover your soulmate's journey
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="edit-card shadow-lg rounded-4 animate-fade-in">

            <div class="row g-0">

                <!-- LEFT SIDEBAR - Burgundy Gradient -->
                <div class="col-lg-4 text-center p-4 sidebar-burgundy">
                    <!-- Profile Image -->
                    <div class="profile-image-wrapper mb-3">
                        <img src="{{ $profile->images->first() ? Storage::url($profile->images->first()->file_path) : 'https://via.placeholder.com/300' }}"
                            class="rounded-circle shadow-lg profile-image" alt="Profile Picture">
                        <div class="profile-status-badge">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>

                    <h3 class="fw-bold mt-3 profile-name text-white">
                        {{ $profile->user->name }}
                    </h3>

                    <p class="profile-profession text-cream mb-3">
                        <i class="fas fa-briefcase me-1"></i> {{ $profile->profession ?? 'Not specified' }}
                    </p>

                    <!-- Membership & Age Badges -->
                    <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                        @if(strtolower($profile->user->plan) === 'premium')
                            <span class="badge-premium px-3 py-2">
                                <i class="fas fa-crown me-1"></i> Premium Member
                            </span>
                        @elseif(strtolower($profile->user->plan) === 'pro')
                            <span class="badge-free px-3 py-2">
                                <i class="fa-regular fa-gem fa-xl" style="color: rgb(255, 255, 255);"></i> Pro Member
                            </span>
                        @else
                            <span class="badge-free px-3 py-2">
                                <i class="fas fa-user me-1"></i> Pro Member
                            </span>
                        @endif

                        <span class="age-tag px-3 py-2">
                            <i class="fas fa-birthday-cake me-1"></i> {{ $profile->age }} Years
                        </span>
                    </div>

                    <!-- Quick Stats Row -->
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="quick-stat-card cream-card">
                                <i class="fas fa-globe-asia"></i>
                                <small>{{ $profile->country ?? 'N/A' }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="quick-stat-card cream-card">
                                <i class="fas fa-heartbeat"></i>
                                <small>{{ ucfirst($profile->marital_status) }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 mb-4">
                        @if($page === "index")
                            <a href="{{ route('profile.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left me-2"></i> Back to profiles
                            </a>
                        @elseif($page === "match")
                            <a href="{{ route('matches.show') }}" class="btn-back">
                                <i class="fas fa-arrow-left me-2"></i> Back to Matches
                            </a>
                        @elseif($page === "dashboard")
                            <a href="{{ route('dashboard') }}" class="btn-back">
                                <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                            </a>
                        @endif

                        <a href="{{ route('profile.report', $profile->id) }}" class="btn-report">
                            <i class="fas fa-flag me-2"></i> Report Profile
                        </a>

                        @if(auth()->user()->role == 'Free' || auth()->user()->role == 'free')
                            <a href="{{ route('plans') }}" class="btn-upgrade1 w-100">
                                <i class="fas fa-gem me-2"></i> Upgrade to Connect <i class="fa-regular fa-gem"
                                    style="color: #5a1620;"></i>
                            </a>
                        @else
                            <form method="POST" action="{{ route('request.send', $profile->id) }}">
                                @csrf
                                <button class="btn-send-request w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Send Interest Request <i
                                        class="fa-solid fa-user-plus" style="color: #5a1620;"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Member Since -->
                    <div class="member-since pt-3">
                        <small class="text-cream-light">
                            <i class="far fa-calendar-alt me-1"></i> Member since {{ $profile->created_at->format('M Y') }}
                        </small>
                    </div>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="col-lg-8 p-4 cream-bg">

                    <!-- Personal Information Section -->
                    <div class="info-section">
                        <h4 class="info-title mb-4">
                            <i class="fas fa-user-circle me-2"></i> Personal Information
                        </h4>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="info-card burgundy-border">
                                    <small class="info-card-label"><i class="fas fa-venus-mars me-1"></i> Gender</small>
                                    <strong class="info-card-value">{{ ucfirst($profile->user->gender) }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card burgundy-border">
                                    <small class="info-card-label"><i class="fas fa-ring me-1"></i> Marital Status</small>
                                    <strong class="info-card-value">{{ ucfirst($profile->marital_status) }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card burgundy-border">
                                    <small class="info-card-label"><i class="fas fa-pray me-1"></i> Religion</small>
                                    <strong class="info-card-value">{{ $profile->religion ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card burgundy-border">
                                    <small class="info-card-label"><i class="fas fa-users me-1"></i> Community</small>
                                    <strong class="info-card-value">{{ $profile->community ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card burgundy-border">
                                    <small class="info-card-label"><i class="fas fa-map-marker-alt me-1"></i>
                                        Country</small>
                                    <strong class="info-card-value">{{ $profile->country ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card burgundy-border">
                                    <small class="info-card-label"><i class="fas fa-city me-1"></i> State</small>
                                    <strong class="info-card-value">{{ $profile->state ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card burgundy-border">
                                    <small class="info-card-label"><i class="fas fa-building me-1"></i> City</small>
                                    <strong class="info-card-value">{{ $profile->city ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="divider-light my-4">

                    <!-- Contact Information Section -->
                    <div class="info-section">
                        <h4 class="info-title mb-4">
                            <i class="fas fa-address-card me-2"></i> Contact Information
                        </h4>

                        @if(strtolower(auth()->user()->plan) == "pro")
                            <div class="contact-card burgundy-light-bg">
                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="contact-item">
                                            <div class="contact-icon burgundy-bg-light">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div>
                                                <small class="contact-label">Email Address</small>
                                                <div class="contact-value">{{ $profile->user->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="contact-item">
                                            <div class="contact-icon burgundy-bg-light">
                                                <i class="fas fa-phone-alt"></i>
                                            </div>
                                            <div>
                                                <small class="contact-label">Phone Number</small>
                                                <div class="contact-value">{{ $profile->user->contact_number ?? 'Not Added' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="contact-locked-card text-center">
                                <i class="fas fa-lock mb-2"></i>
                                <p class="mb-3">Upgrade to Pro to view contact details and connect directly.</p>
                                <a href="{{ route('plans') }}" class="btn-upgrade-small">
                                    <i class="fas fa-crown me-2"></i> Upgrade Now
                                </a>
                            </div>
                        @endif
                    </div>

                    <hr class="divider-light my-4">

                    <!-- Partner Preferences Section -->
                    <div class="info-section">
                        <h4 class="info-title mb-4">
                            <i class="fas fa-heart me-2"></i> Partner Preferences
                        </h4>

                        @php
                            $prefs = is_array($profile->preferences) ? $profile->preferences : json_decode($profile->preferences, true);
                            $prefs = $prefs ?? [];
                        @endphp

                        @if(!empty($prefs))
                            <div class="row g-3">
                                @if(!empty($prefs['age_min']) || !empty($prefs['age_max']))
                                    <div class="col-md-6">
                                        <div class="preference-card burgundy-border">
                                            <i class="fas fa-calendar-alt"></i>
                                            <strong>Age Range:</strong>
                                            <span>{{ $prefs['age_min'] ?? 'Any' }} - {{ $prefs['age_max'] ?? 'Any' }} years</span>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($prefs['religion']))
                                    <div class="col-md-6">
                                        <div class="preference-card burgundy-border">
                                            <i class="fas fa-pray"></i>
                                            <strong>Religion:</strong>
                                            <span>{{ $prefs['religion'] }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($prefs['cast']))
                                    <div class="col-md-6">
                                        <div class="preference-card burgundy-border">
                                            <i class="fas fa-users"></i>
                                            <strong>Community/Caste:</strong>
                                            <span>{{ $prefs['cast'] }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($prefs['marital_status']))
                                    <div class="col-md-6">
                                        <div class="preference-card burgundy-border">
                                            <i class="fas fa-ring"></i>
                                            <strong>Marital Status:</strong>
                                            <span>{{ implode(', ', $prefs['marital_status']) }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($prefs['profession']))
                                    <div class="col-md-6">
                                        <div class="preference-card burgundy-border">
                                            <i class="fas fa-briefcase"></i>
                                            <strong>Profession:</strong>
                                            <span>{{ implode(', ', $prefs['profession']) }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($prefs['location']))
                                    <div class="col-md-6">
                                        <div class="preference-card burgundy-border">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <strong>Location:</strong>
                                            <span>{{ implode(', ', $prefs['location']) }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($prefs['personality']))
                                    <div class="col-12">
                                        <div class="preference-card burgundy-border">
                                            <i class="fas fa-smile"></i>
                                            <strong>Personality Traits:</strong>
                                            <div class="mt-2">
                                                @foreach($prefs['personality'] as $trait)
                                                    @foreach(explode(',', $trait) as $singleTrait)
                                                        <span class="personality-badge">{{ trim($singleTrait) }}</span>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="empty-preferences text-center">
                                <i class="fas fa-heart-broken"></i>
                                <p class="mb-0">No partner preferences specified yet.</p>
                            </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        window.flashData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
        };
    </script>

    <script>
        window.ratingData = {
            status: @json($rating_status)
        };
    </script>
@endsection