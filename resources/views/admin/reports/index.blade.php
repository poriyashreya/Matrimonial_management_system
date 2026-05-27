@extends('admin.layouts.app')

@section('title', 'Profile Verifications')
@section('page-title', 'Profile Verification Requests')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-12">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-2 border-secondary-subtle shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
            <div class="card-header bg-white fw-semibold">
                Verification Requests
            </div>

            <div class="card-body p-0 table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="ps-5">Name</th>
                            <th>ReportedName</th>
                            <th>Date of Resolving</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $i => $v)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td class="ps-5">{{ $v->reporter_name }}</td>
                            <td>{{ $v->reported_name }}</td>
                            <td>{{ date('d-m-Y', strtotime($v->updated_at)) }}</td>
                            <td>
                                @if($v->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($v->status == 'resolved')
                                    <span class="badge bg-success">Resolved</span>
                                @elseif($v->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                            <td class="w-25">
                                <a href="{{ route('admin.reports.show', $v->id) }}" class="btn btn-primary btn-sm">
                                    View Details
                                </a><span class="ps-5"> </span>

                                <a href="{{ route('admin.reports.destroy', $v->id) }}" class="btn btn-danger btn-sm">
                                    Delete Report
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No verification requests found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
