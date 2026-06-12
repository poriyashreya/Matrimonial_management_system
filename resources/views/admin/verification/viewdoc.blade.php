@extends('admin.layouts.app')

@section('title', 'Report Details')
@section('page-title', 'Report Details')

@section('content')

    <div class="container-fluid">

        <div class="mb-3">
            <a href="{{ route('admin.verifications') }}" class="btn btn-sm btn-secondary">
                ← Back to Verifications
            </a>
        </div>

        <div class="row g-4">

            <!-- Reporter -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header fw-semibold">
                        User Details
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p><strong>Profile ID:</strong> {{ $verification->profile_id }}</p>
                            <p><strong>Name:</strong> {{ $verification->name }}</p>
                            <p><strong>Email:</strong> {{ $verification->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header fw-semibold">
                        Profile Details
                    </div>
                    <div class="card-body">
                        <p><strong>Gender:</strong> {{ $verification->gender }}</p>
                        <p><strong>Age:</strong> {{ $verification->age }} years</p>
                        <p><strong>Religion:</strong> {{ $verification->religion }}</p>
                        <p><strong>City:</strong> {{ $verification->city }}</p>
                    </div>
                </div>
            </div>

            <!-- Report Message -->
            <div class="col-12">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header fw-semibold">
                        Verification Document
                    </div>
                    <div class="card-body">
                        <p><strong>Document Type:</strong> {{ ucfirst($verification->doc_type) }}</p>
                        <p class="mb-0">
                            <img src="{{ asset('storage/' . $verification->doc_path) }}"
                                alt="Verification Document" style="height: 300px;" class="img-fluid rounded-4 shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Status & Action -->
            <div class="col-12">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <strong>Status:</strong>
                            @if($verification->status === 0)
                                <span class="badge bg-warning">Pending</span>
                            @elseif($verification->status === 1)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <form method="POST"
                                action="{{ route('admin.verification.approve', $verification->id) }}"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Verify</button>
                            </form>

                            <form method="POST"
                                action="{{ route('admin.verification.reject', $verification->id) }}"
                                class="d-inline">
                                @csrf
                                    <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection