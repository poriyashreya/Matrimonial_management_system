@extends('admin.layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Admin Notifications')

@section('content')

<div class="container-fluid">

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert">
        </button>
    </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">
            Notifications
        </h4>

        <form method="POST" action="{{ route('admin.notifications.readAll') }}">

            @csrf

            <button class="btn btn-primary">
                Mark All Read
            </button>

        </form>

    </div>

    {{-- NOTIFICATION LIST --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            @forelse($notifications as $notification)

            <div class="border rounded-4 p-3 mb-3">

                <div class="d-flex justify-content-between">

                    <div>

                        <p class="mb-1 fw-semibold">

                            {{ $notification->data['message'] ?? 'New Notification' }}

                        </p>

                        <small class="text-muted">

                            {{ $notification->created_at->diffForHumans() }}

                        </small>

                    </div>

                    <div class="d-flex gap-2">

                        @if(is_null($notification->read_at))

                        <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}">

                            @csrf

                            <button class="btn btn-success btn-sm">
                                Mark Read
                            </button>

                        </form>

                        @endif

                        <form method="POST" action="{{ route('admin.notifications.delete', $notification->id) }}">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            </div>

            @empty

            <div class="text-center py-5 text-muted">

                No notifications found.

            </div>

            @endforelse

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">

        {{ $notifications->links() }}

    </div>

</div>

@endsection