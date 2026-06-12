@extends('layouts.app')

@section('content')
    <div class="container pb-5">

        <!-- <h3 class="fw-bold text-center mb-5">📤 Sent Requests</h3> -->
        <div class="section-header text-center mb-5">
            <h3>Sent Requests</h3>
        </div>

        @forelse($requests as $req)
            <div class="request-card mb-3 p-3 shadow-sm rounded-4 d-flex justify-content-between align-items-center">

                {{-- Receiver Info --}}
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $req->receiver->images->first()
                ? Storage::url($req->receiver->images->first()->file_path)
                : 'https://via.placeholder.com/70' }}" class="rounded-circle" width="70" height="70">

                    <div>
                        <h6 class="mb-1">{{ $req->receiver->user->name }}</h6>
                        <small class="text-muted">{{ $req->receiver->profession }}</small>
                    </div>
                </div>

                {{-- Status + Action --}}
                <div class="text-end">

                    {{-- Status --}}
                    @if(
                            $req->is_pending == 1 &&
                            $req->is_canceled == 0 &&
                            $req->is_blocked == 0 &&
                            $req->is_rejected == 0 &&
                            $req->is_accepted == 0
                        )
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif

                    {{-- Cancel Button --}}
                    @if(
                            $req->is_pending == 1 &&
                            $req->is_canceled == 0 &&
                            $req->is_blocked == 0 &&
                            $req->is_rejected == 0 &&
                            $req->is_accepted == 0
                        )
                        <form method="POST" action="{{ route('request.cancel', $req->id) }}" class="mt-2">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">
                                Cancel Request
                            </button>
                        </form>

                    @else
                        {{-- STATUS DISPLAY --}}
                        <div class="request-status">
                            @if($req->is_accepted)
                                <!-- <span class="btn btn-success">Accepted</span> -->

                                <form method="POST" action="{{ route('request.remove', $req->id) }}">
                                    @csrf
                                    <button class="btn btn-danger">Remove Friend</button>
                                </form>
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

            </div>
        @empty
            <div class="empty-modern text-center py-5">
                <div class="empty-modern-icon" style="font-size: 3rem;">📭</div>
                <h4 class="fw-bold mt-3">No Sent Requests</h4>
                <p class="text-muted">
                    You haven’t sent any requests yet.
                </p>

                <a href="{{ route('matches.show') }}" class="btn btn-primary rounded-pill px-4 mt-3">
                    Explore Matches
                </a>
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