@extends('admin.layouts.app')

@section('title', 'User Profile')
@section('page-title', 'User Profile Details')

@section('content')
<div class="row g-4">

    <!-- LEFT PANEL -->
    <div class="col-lg-4">
        <div class="profile-side text-center">

            <div class="avatar-xl mb-3">
                <img src="{{ $profile->images->first()
                    ? asset($profile->images->first()->file_path)
                    : 'https://via.placeholder.com/300' }}" alt="Profile">
            </div>

            <h4 class="fw-bold mb-1">{{ $profile->user->name }}</h4>
            <p class="opacity-75 mb-3">{{ $profile->user->email }}</p>

            <span class="badge-animated mb-3">
                {{ ucfirst($profile->user->role) }} Account
            </span>

            <div class="d-flex justify-content-center gap-2 mt-3">
                <span class="badge-animated">{{ ucfirst($profile->user->gender) }}</span>
                @if ($profile->user->status != 'None')
                    <span class="badge-animated">{{ $profile->user->status }}</span>
                @endif
                <span class="badge-animated">{{ $profile->age }} yrs</span>
            </div>

            <!-- Timeline -->
            <div class="timeline mt-4">
                <div class="timeline-item">
                    <strong>Joined:</strong> {{ $profile->created_at->format('d M Y') }}
                </div>

                @if($profile->verified_by)
                <div class="timeline-item">
                    <strong>Verified:</strong> {{ $profile->updated_at->format('d M Y') }}
                </div>
                @endif
            </div>

            <div class="mt-3">
                @if($profile->user->status == 'None')
                    <form action="{{ route('admin.profile.changerole', $profile->user_id) }}"
                        method="POST">
                        @csrf

                        <button type="submit" class="btn btn-admin w-100">
                            Make Admin
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.profile.changerole', $profile->user_id) }}"
                        method="POST">
                        @csrf

                        <button type="submit" class="btn btn-admin w-100" disabled>
                            Make Admin
                        </button>
                    </form>
                @endif
            </div>

            <div class="mt-3">
                <a class="btn btn-back w-100" href="{{ route('admin.users.index') }}">Back</a>
            </div>

        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="col-lg-8">

        <!-- Religion & Community -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="glass-card">
                    <div class="info-title">Religion</div>
                    <div class="info-value">{{ $profile->religion }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="glass-card">
                    <div class="info-title">Community</div>
                    <div class="info-value">{{ $profile->community }}</div>
                </div>
            </div>
        </div>

        <!-- Marital & Profession -->
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <div class="glass-card">
                    <div class="info-title">Marital Status</div>
                    <div class="info-value text-capitalize">{{ $profile->marital_status }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="glass-card">
                    <div class="info-title">Profession</div>
                    <div class="info-value">{{ $profile->profession }}</div>
                </div>
            </div>
        </div>

        <!-- Preferences -->
        <div class="glass-card mt-3">
            <div class="info-title mb-2">Preferences</div>

            @php $preferences = $profile->preferences; @endphp

            @if(is_array($preferences))
                <ul class="mb-0 ps-3">
                    @foreach($preferences as $key => $value)
                        <li>
                            <strong>{{ Str::of($key)->replace('_',' ')->title() }}:</strong>
                            {{ is_array($value) ? implode(', ', $value) : $value }}
                        </li>
                    @endforeach
                </ul>
            @else
                {{ $preferences }}
            @endif
        </div>

        <!-- Location -->
        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="info-title">Country</div>
                    <div class="info-value">{{ $profile->country }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="info-title">State</div>
                    <div class="info-value">{{ $profile->state }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="info-title">City</div>
                    <div class="info-value">{{ $profile->city }}</div>
                </div>
            </div>
        </div>

        <!-- Status Bar -->
        <div class="status-bar">
            <div>Visibility: {{ ucfirst($profile->visibility) }}</div>
            <div>
                Verification:
                @if($profile->verified_by)
                    <span class="text-success">✔ Verified</span>
                @else
                    <span class="text-warning">⏳ Pending</span>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
