@extends('layouts.app')

@section('content')
    <div class=" container" style="margin-bottom: 5%; margin-top: 2%;">
        <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp">
            <div class="card-body p-4">

                <h4  class="text-danger fw-bold mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Delete Profile
                </h5>

                <p class="text-muted small mb-4">
                    This action is <strong>permanent</strong>. All profile data and images will be removed.
                </p>

                <form action="{{ route('profile.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-lock-fill text-danger"></i>
                            </span>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password" required>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('profile.myprofile') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-danger rounded-pill px-4 btn-delete">
                            <i class="bi bi-trash-fill me-1"></i>
                            Delete Profile
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection