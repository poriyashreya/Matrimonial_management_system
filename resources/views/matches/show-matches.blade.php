@extends('layouts.app')

@section('content')

    <style>
        .match-circle {
            background: conic-gradient(#e11d48
                    {{$score ?? 0}}
                    %, #f3f4f6 0);
        }
    </style>

    <div class="container" style="margin-bottom: 5%;">

        <div class="section-header text-center mb-5">
            <h3>Curated Matches For You</h3>
        </div>

        <div class="row g-4">

            @forelse($matches as $match)
                @php
                    $profile = $match['profile'];
                    $score = $match['score'];
                @endphp

                <div class="col-lg-6">
                    <div class="match-app-card">

                        <!-- Profile Image -->
                        <img src="{{ $profile->images->first()
                ? Storage::url($profile->images->first()->file_path)
                : 'https://via.placeholder.com/300' }}" class="match-app-img" alt="Profile Image">

                        <!-- Profile Details -->
                        <div class="match-app-body">

                            <!-- Match Circle -->
                            <div class="match-circle">
                                <span>{{ $score }}%</span>
                            </div>

                            <h5 class="fw-bold mb-1">
                                {{ $profile->user->name }}, {{ $profile->age }}
                            </h5>

                            <p class="text-muted mb-1">
                                {{ $profile->profession }}
                            </p>

                            <p class="small text-muted mb-2">
                                {{ $profile->city }}, {{ $profile->state }}
                            </p>

                            <p class="small text-muted mb-3">
                                Religion: {{ $profile->religion }} •
                                Status: {{ ucfirst($profile->marital_status) }}
                            </p>

                            <a href="{{ route('user.show',  ['id' => $profile->id, 'page' => 'match']) }}" class="btn btn-outline-danger view-profile-btn">
                                View Profile
                            </a>
                        </div>

                    </div>
                </div>

            @empty

                <!-- EMPTY STATE -->
                <div class="col-12">
                    <div class="empty-modern">
                        <div class="empty-modern-icon">🔍</div>
                        <h4 class="fw-bold mt-3">No Suitable Matches Yet</h4>
                        <p class="text-muted mt-2">
                            We are still searching based on your preferences.
                            <br>Update preferences to improve results.
                        </p>

                        <a href="{{ route('profile.edit') }}" class="btn btn-danger rounded-pill px-4 mt-3">
                            Refine Preferences
                        </a>
                    </div>
                </div>

            @endforelse

        </div>
    </div>

    <script>
        window.ratingData = {
            status: @json($rating_status)
        };
    </script>

@endsection