@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h4 class="fw-bold mb-4">🔔 Notifications</h4>

    @forelse($notifications as $notification)
        <div class="alert alert-light border d-flex justify-content-between align-items-center">
            {{ $notification->data['message'] }}

            @if(is_null($notification->read_at))
                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-primary">Mark as read</button>
                </form>
            @endif
        </div>
    @empty
        <p class="text-muted">No notifications yet</p>
    @endforelse
</div>
@endsection
