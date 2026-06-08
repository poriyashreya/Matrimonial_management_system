@extends('admin.layouts.app')

@section('title', 'Manage Users')
@section('page-title', 'User Management')

@section('content')

    <div class="container-fluid px-4">
        <style>
            /* Matching the admin panel colors */
            :root {
                --admin-primary: #4f46e5;
                --admin-primary-dark: #4338ca;
                --admin-primary-light: #6366f1;
                --admin-bg: #f3f4f6;
                --admin-card: #ffffff;
                --admin-sidebar: #1f2937;
                --admin-header: #ffffff;
                --admin-footer: #1f2937;
                --admin-border: #e5e7eb;
                --admin-text: #111827;
                --admin-text-light: #6b7280;
                --admin-success: #10b981;
                --admin-danger: #ef4444;
                --admin-warning: #f59e0b;
                --admin-info: #3b82f6;
            }

            /* Page Header */
            .page-header-wrapper {
                background: var(--admin-header);
                border-radius: 16px;
                padding: 1.5rem 2rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--admin-border);
            }

            h1 {
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--admin-text);
                margin-bottom: 0.25rem;
            }

            p {
                color: var(--admin-text-light);
                font-size: 0.875rem;
                margin-bottom: 2%;
            }

            .page-header-vibrant {
                margin-bottom: 1.75rem;
                margin-left: 1rem;
            }

            .page-header-vibrant h1 {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--primary);
                margin: 0 0 0.25rem 0;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .page-header-vibrant p {
                color: var(--slate);
                margin: 0;
                font-size: 0.875rem;
            }

            .secure-badge {
                display: inline-block;
                background: #eef2ff;
                color: var(--admin-primary);
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.7rem;
                font-weight: 600;
                margin-bottom: 0.75rem;
            }

            /* Stats Cards */
            .stats-row {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.25rem;
                margin-bottom: 1.5rem;
            }

            .stat-card-admin {
                background: var(--admin-card);
                border-radius: 16px;
                padding: 1.25rem;
                border: 1px solid var(--admin-border);
                transition: all 0.2s ease;
                position: relative;
                overflow: hidden;
            }

            .stat-card-admin:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.1);
                border-color: var(--admin-primary-light);
            }

            .stat-card-admin .stat-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .stat-icon-admin {
                width: 48px;
                height: 48px;
                background: #eef2ff;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--admin-primary);
            }

            .stat-icon-admin i {
                font-size: 1.25rem;
            }

            .stat-label {
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-weight: 600;
                color: var(--admin-text-light);
                margin-bottom: 0.25rem;
            }

            .stat-value {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--admin-text);
                margin-bottom: 0.5rem;
            }

            .stat-footer {
                padding-top: 0.75rem;
                border-top: 1px solid var(--admin-border);
                font-size: 0.7rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--admin-text-light);
            }

            /* Main Card */
            .main-card-admin {
                background: var(--admin-card);
                border-radius: 16px;
                border: 1px solid var(--admin-border);
                overflow: hidden;
                margin-bottom: 1.5rem;
            }

            .card-header-admin {
                padding: 1.25rem 1.5rem;
                background: #fafafa;
                border-bottom: 1px solid var(--admin-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .card-header-admin h5 {
                font-size: 1rem;
                font-weight: 600;
                color: var(--admin-text);
                margin: 0;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .card-header-admin h5 i {
                color: var(--admin-primary);
            }

            .card-header-admin p {
                font-size: 0.75rem;
                color: var(--admin-text-light);
                margin: 4px 0 0 0;
            }

            /* Buttons */
            .btn-view {
                background: var(--admin-primary);
                border: none;
                border-radius: 8px;
                padding: 0.35rem 0.875rem;
                font-size: 13px;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .btn-view:hover {
                background: var(--admin-primary-dark);
                transform: translateY(-1px);
                color: white;
            }

            .btn-make-admin {
                background: var(--admin-success);
                border: none;
                border-radius: 8px;
                padding: 0.35rem 0.875rem;
                font-size: 13px;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .btn-make-admin:hover {
                background: #059669;
                transform: translateY(-1px);
            }

            .btn-demote {
                background: var(--admin-danger);
                border: none;
                border-radius: 8px;
                padding: 0.35rem 0.875rem;
                font-size: 13px;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .btn-demote:hover {
                background: #dc2626;
                transform: translateY(-1px);
            }

            .btn-ban {
                background: var(--admin-danger);
                border: none;
                border-radius: 8px;
                padding: 0.35rem 0.875rem;
                font-size: 13px;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .btn-ban:hover {
                background: #dc2626;
                transform: translateY(-1px);
            }

            .btn-unban {
                background: var(--admin-success);
                border: none;
                border-radius: 8px;
                padding: 0.35rem 0.875rem;
                font-size: 0.7rem;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .btn-unban:hover {
                background: #059669;
                transform: translateY(-1px);
            }

            /* Table Styles */
            .users-table {
                width: 100%;
                border-collapse: collapse;
            }

            .users-table thead th {
                padding: 0.875rem 1rem;
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: var(--admin-text-light);
                background: #f9fafb;
                border-bottom: 1px solid var(--admin-border);
            }

            .users-table tbody td {
                padding: 1rem;
                font-size: 0.875rem;
                color: var(--admin-text);
                border-bottom: 1px solid var(--admin-border);
                vertical-align: middle;
            }

            .users-table tbody tr {
                transition: background 0.2s;
            }

            .users-table tbody tr:hover {
                background: #f9fafb;
            }

            /* User Cell */
            .user-cell {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                background: #eef2ff;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--admin-primary);
                font-weight: 600;
                font-size: 0.875rem;
            }

            .user-name {
                font-weight: 600;
                font-size: 15px;
                color: var(--admin-text);
                margin-bottom: 2px;
            }

            .user-email {
                font-size: 13px;
                color: var(--admin-text-light);
            }

            /* Subscription Badges */
            .sub-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 600;
            }

            .sub-free {
                background: #eef2ff;
                color: var(--admin-primary);
            }

            .sub-premium {
                background: #d1fae5;
                color: #065f46;
            }

            .sub-pro {
                background: #fed7aa;
                color: #92400e;
            }

            /* Status Badges */
            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.7rem;
                font-weight: 600;
            }

            .status-active {
                background: #d1fae5;
                color: #065f46;
            }

            .status-inactive {
                background: #f3f4f6;
                color: #6b7280;
            }

            .status-banned {
                background: #fee2e2;
                color: #991b1b;
            }

            .status-noprofile {
                background: #fef3c7;
                color: #92400e;
            }

            /* Action Buttons Container */
            .action-buttons {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            /* Alert */
            .alert-admin {
                background: #f0fdf4;
                border: 1px solid #bbf7d0;
                border-radius: 12px;
                color: #166534;
                margin-bottom: 1.5rem;
                padding: 0.875rem 1rem;
            }

            /* Pagination */
            .pagination-wrapper-admin {
                padding: 1rem 1.5rem;
                background: #fafafa;
                border-top: 1px solid var(--admin-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .pagination-info-admin {
                font-size: 0.75rem;
                color: var(--admin-text-light);
            }

            .pagination-links-admin {
                display: flex;
                gap: 6px;
            }

            .page-link-admin {
                padding: 0.5rem 0.875rem;
                border-radius: 8px;
                background: white;
                border: 1px solid var(--admin-border);
                color: var(--admin-text);
                font-size: 0.75rem;
                transition: all 0.2s;
                text-decoration: none;
                display: inline-block;
            }

            .page-link-admin.active {
                background: var(--admin-primary);
                border-color: var(--admin-primary);
                color: white;
            }

            .page-link-admin:hover:not(.active) {
                border-color: var(--admin-primary);
                color: var(--admin-primary);
            }

            /* Empty State */
            .empty-state {
                padding: 3rem 1.5rem;
                text-align: center;
            }

            .empty-icon {
                width: 64px;
                height: 64px;
                background: #f3f4f6;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
            }

            .empty-icon i {
                font-size: 1.5rem;
                color: var(--admin-text-light);
            }
        </style>

        <!-- Page Header -->

        <div class="page-header-vibrant">
            <h1>
                <i class="fas fa-user-edit me-2" style="color: #5a1620;"></i>
                User Management
            </h1>
            <p>Manage all registered users, their roles, and account status</p>
        </div>
        <!-- Stats Cards -->


        <!-- Main Table Card -->
        <div class="main-card-admin">
            <div class="card-header-admin">
                <div>
                    <h5>
                        <i class="fas fa-list-ul"></i>
                        All Users
                    </h5>
                    <p>View and manage user accounts, roles, and permissions</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Subscription</th>
                            <th>Status</th>
                            <th colspan="2" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $user)
                            <tr>
                                <td class="text-center fw-semibold" style="color: var(--admin-primary);">
                                    #{{ $i + ($users->firstItem() ?? 1) }}
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-name">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-email">{{ $user->email }}</div>
                                </td>
                                <td>
                                    @if (strtolower($user->plan) === 'free' || $user->plan === 'None')
                                        <span class="sub-badge sub-free">
                                            <i class="fas fa-user fa-xs"></i> Free
                                        </span>
                                    @elseif (strtolower($user->plan) === 'premium')
                                        <span class="sub-badge sub-premium">
                                            <i class="fas fa-crown fa-xs"></i> Premium
                                        </span>
                                    @elseif(strtolower($user->plan) === 'pro')
                                        <span class="sub-badge sub-pro">
                                            <i class="fas fa-bolt fa-xs"></i> Pro
                                        </span>
                                    @else
                                        <span class="sub-badge sub-free">
                                            <i class="fas fa-user fa-xs"></i> None
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->status === 'banned')
                                        <span class="status-badge status-banned">
                                            <i class="fas fa-gavel fa-xs"></i> Banned
                                        </span>
                                    @elseif ($user->is_active === 1)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-circle fa-xs"></i> Active
                                        </span>
                                    @elseif ($user->is_active === 0)
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-circle fa-xs"></i> Inactive
                                        </span>
                                    @else
                                        <span class="status-badge status-noprofile">
                                            <i class="fas fa-exclamation-triangle fa-xs"></i> No Profile
                                        </span>
                                    @endif
                                </td>
                                <td style="width: 180px;">
                                    <div class="action-buttons">
                                        @if($user->profile_id)
                                            @if ($user->role === 'admin')
                                                <form action="{{ route('admin.profile.demote', $user->user_id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-demote">
                                                        <i class="fas fa-arrow-down"></i> Demote
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('admin.users.show', $user->profile_id) }}" class="btn-view">
                                                    <i class="fas fa-eye"></i> View Profile
                                                </a>
                                            @endif
                                        @else
                                            @if (strtolower($user->role) === 'user' || strtolower($user->role) === 'free')
                                                <form action="{{ route('admin.profile.changerole', $user->user_id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-make-admin">
                                                        <i class="fas fa-user-shield"></i> Make Admin
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.profile.demote', $user->user_id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-demote">
                                                        <i class="fas fa-arrow-down"></i> Demote
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td style="width: 150px;">
                                    <div class="action-buttons">
                                        @if($user->status == 'None' || $user->status == 'none')
                                            <form method="POST" action="{{ route('admin.user.ban', $user->user_id) }}"
                                                class="d-inline">
                                                @csrf
                                                <button class="btn-ban">
                                                    <i class="fas fa-ban"></i> Ban User
                                                </button>
                                            </form>
                                        @elseif($user->status === 'banned')
                                            <form method="POST" action="{{ route('admin.user.unban', $user->user_id) }}"
                                                class="d-inline">
                                                @csrf
                                                <button class="btn-unban">
                                                    <i class="fas fa-check-circle"></i> Unban User
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-users-slash"></i>
                                        </div>
                                        <h6 class="text-muted mb-1">No users found</h6>
                                        <p class="text-muted small mb-0">Users will appear here once they register</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
                <div class="pagination-wrapper-admin">
                    <div class="pagination-info-admin">
                        <i class="fas fa-chart-simple me-1"></i>
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                    </div>
                    <div class="pagination-links-admin">
                        {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#5a1620',
                    timer: 3000
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#5a1620',
                    timer: 3000
                });
            @endif
                        });
    </script>
@endsection