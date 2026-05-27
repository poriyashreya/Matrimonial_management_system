@extends('layouts.app')

@section('content')

    <div style="margin-bottom: 5%; margin-top: -2% !important;">
        @php
            use Illuminate\Support\Str;
            $prefs = is_array($profile->preferences)
                ? $profile->preferences
                : json_decode($profile->preferences, true);
        @endphp

        <!-- ================= COVER HEADER ================= -->
        <section class="profile-cover">
            <div class="overlay"></div>
            <div class="container text-center text-white">
                <h2 class="animate-slide-down">{{ $profile->user->name }}</h2>
                <p class="animate-slide-down delay-1">
                    {{ $profile->profession }} • {{ $profile->city }}
                </p>
            </div>
        </section>

        <!-- ================= PROFILE CARD ================= -->
        <div class="container">
            <div class="profile-floating-card animate-fade-in">
                @if(session('success'))
                    <div class="container">
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif

                @if(session('status'))
                    <div class="container">
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <strong>{{ session('status') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif
                <div class="row">

                    <!-- LEFT PROFILE SUMMARY -->
                    <div class="col-lg-4 text-center">

                        <img src="{{ $profile->images->first()
                            ? asset($profile->images->first()->file_path)
                            : 'https://via.placeholder.com/300' }}" class="profile-avatar shadow" alt="Profile Image">

                        <h4 class="mt-3 fw-bold">{{ $profile->user->name }}</h4>
                        <p class="text-muted mb-2">{{ $profile->profession }}</p>

                        <span class="badge bg-danger px-3 py-2">
                            {{ $profile->age }} Years
                        </span>

                        <!-- ACTION BUTTONS -->
                        <div class="mt-4 d-grid gap-2">
                            <a href="{{ route('profile.index') }}" class="btn edit-cancel-btn">
                                Back
                            </a>

                            <a href="{{ route('profile.report', $profile->id) }}" class="btn delete-btn1">
                                Report this profile
                            </a>


                            <form method="POST" action="{{ route('request.send', $profile->id) }}">
                                @csrf
                                <button class="btn edit-btn w-100">
                                    Follow
                                </button>
                            </form>

                        </div>

                    </div>

                    <!-- ============================ RIGHT DETAILS =========================== -->
                    <div class="col-lg-8">

                        <!-- =================== PERSONAL INFO ==================== -->
                        <div class="info-box">
                            <h5 class="info-title">Personal Information</h5>

                            <div class="row">
                                <div class="col-md-6"><strong>Gender:</strong> {{ $profile->user->gender }}</div>
                                <div class="col-md-6"><strong>Marital Status:</strong>
                                    {{ ucfirst($profile->marital_status) }}
                                </div>
                                <div class="col-md-6"><strong>Religion:</strong> {{ $profile->religion }}</div>
                                <div class="col-md-6"><strong>Community:</strong> {{ $profile->community }}</div>
                            </div>
                        </div>

                        <!-- LOCATION & CAREER -->
                        <div class="info-box">
                            <h5 class="info-title">Location & Career</h5>

                            <div class="row">
                                <div class="col-md-6"><strong>Country:</strong> {{ $profile->country }}</div>
                                <div class="col-md-6"><strong>State:</strong> {{ $profile->state }}</div>
                                <div class="col-md-6"><strong>City:</strong> {{ $profile->city }}</div>
                                <div class="col-md-6"><strong>Profession:</strong> {{ $profile->profession }}</div>
                            </div>
                        </div>

                        <!-- ================= PARTNER PREFERENCES ================= -->
                        <div class="info-box">
                            <h5 class="info-title">Partner Preferences</h5>

                            @if(!empty($prefs))
                                <ul class="preference-list">

                                    @if(isset($prefs['age_min'], $prefs['age_max']))
                                        <li>
                                            <strong>Age Range:</strong>
                                            {{ $prefs['age_min'] }} – {{ $prefs['age_max'] }} years
                                        </li>
                                    @endif

                                    @if(!empty($prefs['religion']))
                                        <li>
                                            <strong>Religion:</strong> {{ $prefs['religion'] }}
                                        </li>
                                    @endif

                                    @if(!empty($prefs['marital_status']))
                                        <li>
                                            <strong>Marital Status:</strong>
                                            {{ implode(', ', $prefs['marital_status']) }}
                                        </li>
                                    @endif

                                    @if(!empty($prefs['profession']))
                                        <li>
                                            <strong>Preferred Profession:</strong>
                                            {{ implode(', ', $prefs['profession']) }}
                                        </li>
                                    @endif

                                    @if(!empty($prefs['personality']))
                                        <li>
                                            <strong>Personality Traits:</strong>
                                            @foreach($prefs['personality'] as $trait)
                                                {{ ucfirst($trait) }}
                                                <span class="badge bg-light text-dark me-1">
                                                    <!-- {{ ucfirst($trait) }} -->
                                                </span>
                                            @endforeach
                                        </li>
                                    @endif

                                </ul>
                            @else
                                <p class="text-muted">No partner preferences added.</p>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection