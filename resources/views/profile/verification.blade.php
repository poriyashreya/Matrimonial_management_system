@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">

                <div class="verify-card">

                    {{-- HEADER --}}
                    <div class="verify-header">
                        <div class="verify-icon">🔐</div>
                        <h4 class="fw-bold mb-1">Profile Verification</h4>
                        <p class="mb-0 small">
                            Get verified to increase trust & profile visibility
                        </p>
                    </div>

                    <div class="card-body p-4">
                        @php
                            $status = $verification->status ?? null;
                        @endphp

                        @if($status !== null)

                            @if($status == 1)
                                <div class="status-badge status-verified mb-4">
                                    ✅ Your profile is verified
                                </div>

                            @elseif($status == 0)
                                <div class="status-badge status-pending mb-4">
                                    ⏳ Verification is under review
                                </div>

                            @elseif($status == 2)
                                <div class="status-badge status-rejected mb-4">
                                    ❌ Verification rejected. Please upload valid documents.
                                </div>

                            @endif

                        @else
                            <div class="alert alert-info mb-4">
                                ℹ️ You have not submitted verification yet.
                            </div>
                        @endif


                        {{-- FORM --}}
                        @if($status != 1)
                            <form action="{{ route('profile.verification.submit') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        📄 Document Type
                                    </label>
                                    <select name="document_type" class="form-select" required>
                                        <option value="">Select document</option>

                                        <option value="aadhaar" {{ old('document_type') == 'aadhaar' ? 'selected' : '' }}>
                                            Aadhaar Card
                                        </option>

                                        <option value="pan" {{ old('document_type') == 'pan' ? 'selected' : '' }}>
                                            PAN Card
                                        </option>

                                        <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>
                                            Passport
                                        </option>

                                        <option value="driving_license" {{ old('document_type') == 'driving_license' ? 'selected' : '' }}>
                                            Driving License
                                        </option>
                                    </select>

                                    @error('document_type')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        📤 Upload Document
                                    </label>
                                    <input type="file" name="document_file" class="form-control" required>
                                    <small class="text-muted">
                                        JPG, PNG or PDF • Max 2MB
                                    </small>
                                    @error('document_file')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @php
                            $status = $verification->status ?? null;
                        @endphp

                                @if($status !== null)
                                    @if($status == 0)
                                        <button class="btn submit-btn disabled text-white w-100 mt-3">
                                            Submit for Verification
                                        </button>

                                    @elseif($status == 2)
                                        <button class="btn submit-btn text-white w-100 mt-3">
                                            Submit for Verification
                                        </button>

                                    @endif

                                @else
                                    <button class="btn submit-btn text-white w-100 mt-3">
                                        Submit for Verification
                                    </button>
                                @endif


                                <a href="{{ route('profile.myprofile') }}" class="btn vcancel-btn w-100 mt-3">
                                    Back
                                </a>
                            </form>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection