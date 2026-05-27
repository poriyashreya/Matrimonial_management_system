@extends('layouts.app')

@section('content')

    <div class="container" style="margin-bottom: 5%;">

        <!-- PAGE HEADER -->
        <div class="edit-header mb-4 text-center">
            <h2 class="text-white animate-slide-down">Profile Details</h2>
            <p class="text-light animate-slide-down delay-1">Your personal and partner information</p>
        </div>

        <!-- MAIN CARD -->
        <div class="edit-card shadow-lg p-4 rounded-4 animate-fade-in">

            <div class="row">

                <!-- LEFT COLUMN -->
                <div class="col-lg-4 text-center border-end">

                    <!-- PROFILE PHOTO -->
                    <div class="mb-3">
                        <img src="{{ $profile->images->first() ? asset($profile->images->first()->file_path) : 'https://via.placeholder.com/300' }}"
                            alt="Profile Photo" class="rounded-circle shadow" width="180" height="180"
                            style="object-fit: cover;">
                    </div>

                    <h3 class="fw-bold mt-3">{{ $profile->user->name }}</h3>
                    <p class="text-muted">{{ $profile->profession }}</p>

                    <!-- TAGS -->
                    <div class="mt-3">
                        <span class="tag">{{ $profile->age }} Years</span>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="mt-4">
                        <!-- <a href="{{ route('request.view') }}" class="btn btn-info folowers-btn w-75 mb-2">View Folowers</a> -->
                        <a href="{{ route('profile.verification') }}" class="btn btn-verify folowers-btn w-75 mb-2">Verify Your Profile</a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-success edit-btn w-75 mb-2">Edit Your Profile</a>
                        <a href="{{ route('profile.deleteform') }}" class="btn delete-btn1 w-75 mb-2">Delete Profile</a>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-8">

                    <!-- PERSONAL INFO -->
                    <div class="p-3">
                        <div class="info-box">
                            <h4 class="info-title mb-3">Personal Information</h4>

                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Gender:</strong> {{ ucfirst($profile->user->gender) }}</div>
                                <div class="col-md-6"><strong>Marital Status:</strong> {{ $profile->marital_status }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Religion:</strong> {{ $profile->religion }}</div>
                                <div class="col-md-6"><strong>Community:</strong> {{ $profile->community }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Country:</strong> {{ $profile->country }}</div>
                                <div class="col-md-6"><strong>State:</strong> {{ $profile->state }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6"><strong>City:</strong> {{ $profile->city }}</div>
                                <div class="col-md-6"><strong>Profession:</strong> {{ $profile->profession }}</div>
                            </div>
                        </div>

                        <hr>

                        <!-- <h4 class="section-title mb-3">Partner Preferences</h4> -->
                        <div class="info-box">
                            <h5 class="info-title">Partner Preferences</h5>

                            @php
                                $prefs = is_array($profile->preferences)
                                    ? $profile->preferences
                                    : json_decode($profile->preferences, true);
                                $prefs = $prefs ?? [];
                            @endphp

                            @if(!empty($prefs))
                                <ul class="preference-list list-unstyled">
                                    @if(!empty($prefs['age_min']) || !empty($prefs['age_max']))
                                        <li><strong>Age:</strong>
                                            {{ $prefs['age_min'] ?? 'Any' }} - {{ $prefs['age_max'] ?? 'Any' }} years
                                        </li>
                                    @endif

                                    @if(!empty($prefs['religion']))
                                        <li><strong>Religion:</strong> {{ $prefs['religion'] }}</li>
                                    @endif

                                    @if(!empty($prefs['Cast']))
                                        <li><strong>Cast:</strong> {{ $prefs['Cast'] }}</li>
                                    @endif

                                    @if(!empty($prefs['marital_status']))
                                        <li><strong>Marital Status:</strong> {{ implode(', ', $prefs['marital_status']) }}</li>
                                    @endif

                                    @if(!empty($prefs['profession']))
                                        <li><strong>Profession:</strong> {{ implode(', ', $prefs['profession']) }}</li>
                                    @endif

                                    @if(!empty($prefs['location']))
                                        <li><strong>location:</strong> {{ implode(', ', $prefs['location']) }}</li>
                                    @endif

                                    @if(!empty($prefs['personality']))
                                        <li><strong>Personality Traits:</strong> {{ implode(', ', $prefs['personality']) }}</li>
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