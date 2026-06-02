@extends('layouts.app')

@section('content')
    <div class="container" style="margin-bottom: 5%;">

        <div class="section-header text-center mb-5">
            <h3>Received Requests</h3>
        </div>

        @forelse($requests as $req)
            <div class="request-card">

                <div class="request-info">
                    <img src="{{ $req->sender->images->first()
                ? Storage::url($req->sender->images->first()->file_path)
                : 'https://via.placeholder.com/70' }}" class="request-avatar">

                    <div class="request-text">
                        <h6>{{ $req->sender->user->name }}</h6>
                        <p>{{ $req->sender->profession }}</p>
                    </div>
                </div>

                {{-- ACTIONS --}}
                @if(
                        $req->is_pending == 1 &&
                        $req->is_canceled == 0 &&
                        $req->is_blocked == 0 &&
                        $req->is_rejected == 0 &&
                        $req->is_accepted == 0
                    )
                    <div class="request-actions">

                        <form method="POST" action="{{ route('request.accept', $req->id) }}">
                            @csrf
                            <button class="btn-accept btn-sm">Accept</button>
                        </form>

                        <form method="POST" action="{{ route('request.reject', $req->id) }}">
                            @csrf
                            <button class="btn-reject btn-sm">Reject</button>
                        </form>

                        <form method="POST" action="{{ route('request.block', $req->id) }}">
                            @csrf
                            <button class="btn-block btn-sm">Block</button>
                        </form>


                    </div>

                @else
                    {{-- STATUS DISPLAY --}}
                    <div class="request-status">

                        @if($req->is_accepted)
                            <span class="badge bg-success">Accepted</span>

                        @elseif($req->is_rejected)
                            <span class="badge bg-danger">Rejected</span>

                        @elseif($req->is_canceled)
                            <span class="badge bg-secondary">Canceled</span>

                        @elseif($req->is_blocked)
                            <span class="badge bg-dark">Blocked</span>

                        @endif

                    </div>
                @endif

            </div>




        @empty
            <div class="col-12">
                <div class="empty-modern text-center py-5">
                    <div class="empty-modern-icon" style="font-size: 3rem;">📭</div>
                    <h4 class="fw-bold mt-3">No Received Requests</h4>
                    <p class="text-muted mt-2">
                        You haven't received any requests yet.<br>
                        Once users show interest, they will appear here.
                    </p>

                    <a href="{{ route('matches.show') }}" class="btn btn-primary rounded-pill px-4 mt-3">
                        Explore Matches
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <script>
        window.ratingData = {
            status: @json($rating_status)
        };
    </script>

    <script>
        window.flashData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
        };
    </script>
@endsection