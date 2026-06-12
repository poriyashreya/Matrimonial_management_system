@extends('layouts.user')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">🚨 Reported Profiles</h3>

    @foreach($reports as $report)
        <div class="card mb-3 p-3">
            <strong>{{ $report->reportedProfile->user->name }}</strong>
            <p>Reason: {{ $report->reason }}</p>
            <span class="badge bg-warning">{{ ucfirst($report->status) }}</span>

            @if($report->status == 'pending')
                <form method="POST" class="mt-2">
                    @csrf
                    <button formaction="{{ route('admin.reports.resolve', $report) }}"
                        class="btn btn-success btn-sm">Resolve</button>

                    <button formaction="{{ route('admin.reports.reject', $report) }}"
                        class="btn btn-danger btn-sm">Reject</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection
