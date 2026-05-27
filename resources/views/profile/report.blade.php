@extends('layouts.app')

@section('content')

<div class="container my-5">

    <!-- PAGE HEADER -->
    <div class="text-center mb-5 animate-fade-in-down">
        <h2 class="report-title fw-bold">Report Profile</h2>
        <p class="report-subtitle">Report this profile for inappropriate behavior</p>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show animate-fade-in-up" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- REPORT FORM CARD -->
    <div class="card shadow-lg p-5 rounded-4 report-card animate-fade-in-up">
        <form action="{{ route('profile.report.store', $profile->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-bold text-white">Reporting Profile</label>
                <input type="text" class="form-control" value="{{ $profile->user->name }}" disabled>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-white">Reason</label>
                <select name="reason" class="form-select @error('reason') is-invalid @enderror">
                    <option value="">Select a reason</option>
                    <option value="Fake Profile" {{ old('reason')=='Fake Profile' ? 'selected' : '' }}>Fake Profile</option>
                    <option value="Inappropriate Content" {{ old('reason')=='Inappropriate Content' ? 'selected' : '' }}>Inappropriate Content</option>
                    <option value="Harassment" {{ old('reason')=='Harassment' ? 'selected' : '' }}>Harassment</option>
                    <option value="Other" {{ old('reason')=='Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('reason')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-white">Message (optional)</label>
                <textarea name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('user.show', $profile->user_id) }}" class="btn btn-cancel shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="btn btn-report shadow-sm animate-pulse">
                    Report
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
