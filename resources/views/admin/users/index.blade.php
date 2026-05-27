@extends('admin.layouts.app')

@section('title', 'Manage Users')
@section('page-title', 'User Management')

@section('content')
    <div class="row g-4 mb-4">

        <div class="col-12">
            <div class="card border-2 border-secondary-subtle shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <div class="card-body p-0 table-responsive">
                    <table class="table align-middle mb-0 rounded-5">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="ps-5">Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $i => $user)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="ps-5">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role === 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @elseif ($user->role === 'free')
                                            <div class="badge bg-primary">Free User</div>
                                        @endif
                                    </td>
                                    <td>

                                        @if ($user->is_active === 1)
                                            <span class="badge bg-success">Active</span>
                                        @elseif ($user->is_active === 0)
                                            <span class="badge bg-secondary">Inactive</span>
                                        @else
                                            <span class="badge bg-warning">No Profile</span>
                                        @endif
                                    </td>
                                    @if($user->profile_id)
                                        @if ($user->role === 'admin')
                                            <td>
                                                <form action="{{ route('admin.profile.demote', $user->user_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        Demote to User
                                                    </button>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <a href="{{ route('admin.users.show', $user->profile_id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                    View Profile
                                                </a>
                                            </td>
                                        @endif

                                    @else
                                        <td>
                                            @if ($user->role === 'free')
                                                <form action="{{ route('admin.profile.changerole', $user->user_id) }}"
                                                    method="POST">
                                                    @csrf

                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Make Admin
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.profile.demote', $user->user_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        Demote to User
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endif


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-4 text-muted">
                                        No users found.
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