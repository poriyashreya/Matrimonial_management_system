@extends('admin.layouts.app')

@section('title', 'Profile Verifications')
@section('page-title', 'Profile Verification Requests')

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
                padding: 24px 32px;
                margin-bottom: 24px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--admin-border);
            }

            .page-header-wrapper h1 {
                font-size: 24px;
                font-weight: 600;
                color: var(--admin-text);
                margin-bottom: 4px;
            }

            .page-header-wrapper p {
                color: var(--admin-text-light);
                font-size: 14px;
                margin: 0;
            }

            .secure-badge {
                display: inline-block;
                background: #ffecef;
                color: #6b1f2b;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                margin-bottom: 12px;
            }

            /* Stats Cards */
            .stats-row {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 24px;
            }

            .stat-card-admin {
                background: var(--admin-card);
                border-radius: 16px;
                padding: 20px;
                border: 2px solid var(--admin-border);
                transition: all 0.2s ease;
                position: relative;
                overflow: hidden;
            }

            .stat-card-admin:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.1);
                border-color: #6b1f2b;
            }

            .stat-card-admin .stat-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 16px;
            }

            .stat-icon-admin {
                width: 48px;
                height: 48px;
                background: #ffecef;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #6b1f2b;
            }

            .stat-icon-admin i {
                font-size: 20px;
            }

            .stat-label {
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-weight: 600;
                color: var(--admin-text-light);
                margin-bottom: 4px;
            }

            .stat-value {
                font-size: 28px;
                font-weight: 700;
                color: var(--admin-text);
                margin-bottom: 8px;
            }

            .stat-footer {
                padding-top: 12px;
                border-top: 1px solid var(--admin-border);
                font-size: 12px;
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--admin-text-light);
            }

            /* Main Card */
            .main-card-admin {
                background: var(--admin-card);
                border-radius: 16px;
                border: 1px solid var(--admin-border);
                overflow: hidden;
                margin-bottom: 24px;
            }

            .card-header-admin {
                padding: 20px 24px;
                background: #fafafa;
                border-bottom: 1px solid var(--admin-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 16px;
            }

            .card-header-admin h5 {
                font-size: 16px;
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
                font-size: 12px;
                color: var(--admin-text-light);
                margin: 4px 0 0 0;
            }

            /* Buttons */
            .btn-admin-outline {
                background: white;
                border: 1px solid var(--admin-border);
                border-radius: 8px;
                padding: 8px 16px;
                font-size: 12px;
                font-weight: 500;
                color: var(--admin-text);
                transition: all 0.2s;
                cursor: pointer;
            }

            .btn-admin-outline:hover {
                border-color: var(--admin-primary);
                color: var(--admin-primary);
            }

            .btn-admin-primary {
                background: var(--admin-primary);
                border: none;
                border-radius: 8px;
                padding: 8px 16px;
                font-size: 12px;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
            }

            .btn-admin-primary:hover {
                background: var(--admin-primary-dark);
            }

            .btn-view {
                background: var(--admin-primary);
                border: none;
                border-radius: 8px;
                padding: 6px 14px;
                font-size: 13px;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                margin-right: 20px;
            }

            .btn-view:hover {
                background: var(--admin-primary-dark);
                transform: translateY(-1px);
                color: white;
            }

            .btn-delete {
                background: var(--admin-danger);
                border: none;
                border-radius: 8px;
                padding: 6px 14px;
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

            .btn-delete:hover {
                background: #dc2626;
                transform: translateY(-1px);
                color: white;
            }

            /* Table Styles */
            .verification-table {
                width: 100%;
                border-collapse: collapse;
            }

            .verification-table thead th {
                padding: 14px 16px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #4e1620;
                background: #f9fafb;
                border-bottom: 1px solid var(--admin-border);
            }

            .verification-table tbody td {
                padding: 16px;
                font-size: 14px;
                color: var(--admin-text);
                border-bottom: 1px solid var(--admin-border);
                vertical-align: middle;
            }

            .verification-table tbody tr {
                transition: background 0.2s;
            }

            .verification-table tbody tr:hover {
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
                font-size: 14px;
            }

            .user-name {
                font-weight: 600;
                font-size: 16px !important;
                color: var(--admin-text);
                margin-bottom: 2px;
            }

            .user-email {
                font-size: 13px;
                color: var(--admin-text-light);
            }

            /* Status Badges */
            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .status-pending {
                background: #fef3c7;
                color: #92400e;
            }

            .status-resolved {
                background: #d1fae5;
                color: #065f46;
            }

            .status-rejected {
                background: #fee2e2;
                color: #991b1b;
            }

            /* Date Cell */
            .date-cell {
                font-size: 14px;
                color: var(--admin-text-light);
            }

            /* Action Buttons Container */
            .action-buttons {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            /* Pagination */
            .pagination-wrapper-admin {
                padding: 16px 24px;
                background: #fafafa;
                border-top: 1px solid var(--admin-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 16px;
            }

            .pagination-info-admin {
                font-size: 12px;
                color: var(--admin-text-light);
            }

            .pagination-links-admin {
                display: flex;
                gap: 6px;
            }

            .page-link-admin {
                padding: 8px 14px;
                border-radius: 8px;
                background: white;
                border: 1px solid var(--admin-border);
                color: var(--admin-text);
                font-size: 12px;
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
                padding: 48px 24px;
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
                margin: 0 auto 16px;
            }

            .empty-icon i {
                font-size: 24px;
                color: var(--admin-text-light);
            }
        </style>

        <!-- Page Header -->
        <!-- <div class="page-header-wrapper">
                                                                                                                                                                                <div class="secure-badge">
                                                                                                                                                                                    <i class="fas fa-id-card me-1"></i> VERIFICATION SYSTEM
                                                                                                                                                                                </div>
                                                                                                                                                                                <h1>
                                                                                                                                                                                    <i class="fas fa-user-check me-2"></i>
                                                                                                                                                                                    Profile Verification Requests
                                                                                                                                                                                </h1>
                                                                                                                                                                                <p>Review and manage user profile verification requests</p>
                                                                                                                                                                            </div> -->


        <!-- Stats Cards -->
        <div class="stats-row">
            <!-- Total Requests -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Requests</div>
                        <div class="stat-value">{{ $reports->total() ?? count($reports) }}</div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-chart-line"></i>
                    <span>All verification requests</span>
                </div>
            </div>

            <!-- Pending -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Pending</div>
                        <div class="stat-value" style="color: var(--admin-warning);">
                            {{ $reports->where('status', 'pending')->count() }}
                        </div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Awaiting review</span>
                </div>
            </div>

            <!-- Resolved -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Resolved</div>
                        <div class="stat-value" style="color: var(--admin-success);">
                            {{ $reports->where('status', 'resolved')->count() }}
                        </div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-check"></i>
                    <span>Approved verifications</span>
                </div>
            </div>

            <!-- Rejected -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Rejected</div>
                        <div class="stat-value" style="color: var(--admin-danger);">
                            {{ $reports->where('status', 'rejected')->count() }}
                        </div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-ban"></i>
                    <span>Declined requests</span>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="main-card-admin">
            <div class="card-header-admin">
                <div>
                    <h5>
                        <i class="fas fa-list-ul"></i>
                        Verification Requests
                    </h5>
                    <p>View and manage all profile verification submissions</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="verification-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Reporter</th>
                            <th>Reported User</th>
                            <th>Date of Resolving</th>
                            <th>Status</th>
                            <th style="width: 350px; padding-left: 7%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $i => $v)
                            <tr>
                                <td class="text-center fw-semibold" style="color: var(--admin-primary);">
                                    #{{ $i + $reports->firstItem() ?? $i + 1 }}
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <div>
                                            <div class="user-name">{{ $v->reporter_name }}</div>
                                            <div class="user-email">{{ $v->reporter_email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <div>
                                            <div class="user-name">{{ $v->reported_name }}</div>
                                            <div class="user-email">{{ $v->reported_email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-cell">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ date('d M Y', strtotime($v->updated_at)) }}
                                    </div>
                                </td>
                                <td>
                                    @if($v->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-hourglass-half fa-xs"></i> Pending
                                        </span>
                                    @elseif($v->status == 'resolved')
                                        <span class="status-badge status-resolved">
                                            <i class="fas fa-check-circle fa-xs"></i> Resolved
                                        </span>
                                    @elseif($v->status == 'rejected')
                                        <span class="status-badge status-rejected">
                                            <i class="fas fa-times-circle fa-xs"></i> Rejected
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.reports.show', $v->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                        <a href="{{ route('admin.reports.destroy', $v->id) }}" class="btn-delete"
                                            onclick="event.preventDefault(); confirmDelete('{{ route('admin.reports.destroy', $v->id) }}')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h6 class="text-muted mb-1">No verification requests found</h6>
                                        <p class="text-muted small mb-0">All verification requests will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($reports) && method_exists($reports, 'hasPages') && $reports->hasPages())
                <div class="pagination-wrapper-admin">
                    <div class="pagination-info-admin">
                        <i class="fas fa-chart-simple me-1"></i>
                        Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
                    </div>
                    <div class="pagination-links-admin">
                        {{ $reports->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This verification request will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>

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