@extends('admin.layouts.app')

@section('title', 'Report Details')
@section('page-title', 'Report Details')

@section('content')

    <div class="container-fluid">

        <div class="mb-3">
            <a href="{{ route('admin.reports') }}" class="btn btn-sm btn-secondary">
                ← Back to Reports
            </a>
        </div>

        <div class="row g-4">

            <!-- Reporter -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header fw-semibold">
                        👤 Reporter Details
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $report->reporter_name }}</p>
                        <p><strong>Email:</strong> {{ $report->reporter_email }}</p>
                    </div>
                </div>
            </div>

            <!-- Reported -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-4 border-danger">
                    <div class="card-header fw-semibold text-danger">
                        🚨 Reported User
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $report->reported_name }}</p>
                        <p><strong>Email:</strong> {{ $report->reported_email }}</p>
                    </div>
                </div>
            </div>

            <!-- Report Message -->
            <div class="col-12">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header fw-semibold">
                        📝 Report Reason & Message
                    </div>
                    <div class="card-body">
                        <p><strong>Reason:</strong> {{ ucfirst($report->reason) }}</p>
                        <p class="mb-0">
                            <strong>Description:</strong><br>
                            {{ $report->message ?? 'No additional message provided.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status & Action -->
            <div class="col-12">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <strong>Status:</strong>
                            @if($report->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($report->status == 'resolved')
                                <span class="badge bg-success">Resolved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <!-- Replace Resolve Button -->
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#resolveModal">Resolve</button>

                            <!-- Resolve Modal -->
                            <div class="modal fade" id="resolveModal" tabindex="-1" aria-labelledby="resolveModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.reports.resolve', $report->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="resolveModalLabel">Resolve Report</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Choose action for the reported user:</p>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="action_type"
                                                        value="warning" id="warningAction" checked>
                                                    <label class="form-check-label" for="warningAction">Send Warning</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="action_type"
                                                        value="ban" id="banAction">
                                                    <label class="form-check-label" for="banAction">Ban Profile</label>
                                                </div>
                                                <div class="mt-3">
                                                    <label>Optional Message:</label>
                                                    <textarea class="form-control" name="message"
                                                        placeholder="Enter message to send..." rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Confirm</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <form method="POST" action="#">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>

                            <form action="{{ route('admin.reports.destroy', $report->id) }}"method="GET">
                                @csrf
                                <button class="btn btn-danger btn-sm">Delete report</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection