@extends('admin.layouts.app')

@section('title', 'Verify Profiles')
@section('page-title', 'Profile Verification')

@section('content')

    <div class="container-fluid px-4">
        <style>
            /* Fresh & Vibrant Color Scheme - Using PX Units */
            :root {
                --primary: #5a1620;
                --primary-dark: #3d0e15;
                --primary-light: #7a2a36;

                --teal: #0d9488;
                --teal-light: #14b8a6;
                --teal-soft: #ccfbf1;

                --amber: #d97706;
                --amber-light: #f59e0b;
                --amber-soft: #fef3c7;

                --indigo: #4f46e5;
                --indigo-light: #6366f1;
                --indigo-soft: #e0e7ff;

                --rose: #e11d48;
                --rose-light: #fb7185;
                --rose-soft: #ffe4e6;

                --emerald: #059669;
                --emerald-light: #10b981;
                --emerald-soft: #d1fae5;

                --slate: #64748b;
                --slate-light: #94a3b8;

                --bg-main: #f8fafc;
                --bg-card: #ffffff;
                --border: #e2e8f0;
                --admin-border: #e5e7eb;


                --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            }

            /* Main Container */
            .verification-container {
                max-width: 1400px;
                margin: 0 auto;
            }

            /* Page Header */
            .page-header-vibrant {
                margin-bottom: 28px;
            }

            .page-header-vibrant h1 {
                font-size: 28px;
                font-weight: 700;
                color: var(--primary);
                margin: 0 0 4px 0;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .page-header-vibrant p {
                color: var(--slate);
                margin: 0;
                font-size: 14px;
            }

            /* Stats Grid */
            .stats-grid-vibrant {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 28px;
            }

            .stat-card-vibrant {
                background: var(--bg-card);
                border-radius: 20px;
                padding: 20px;
                border: 1px solid var(--border);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .stat-card-vibrant:hover {
                transform: translateY(-4px);
                box-shadow: var(--shadow-lg);
            }

            /* Card 1 - Teal */
            .stat-card-vibrant:nth-child(1) .stat-icon-vibrant {
                background: var(--teal-soft);
                color: var(--teal);
            }

            .stat-card-vibrant:nth-child(1):hover {
                border-color: var(--teal);
            }

            /* Card 2 - Amber */
            .stat-card-vibrant:nth-child(2) .stat-icon-vibrant {
                background: var(--amber-soft);
                color: var(--amber);
            }

            .stat-card-vibrant:nth-child(2):hover {
                border-color: var(--amber);
            }

            /* Card 3 - Indigo */
            .stat-card-vibrant:nth-child(3) .stat-icon-vibrant {
                background: var(--indigo-soft);
                color: var(--indigo);
            }

            .stat-card-vibrant:nth-child(3):hover {
                border-color: var(--indigo);
            }

            /* Card 4 - Rose */
            .stat-card-vibrant:nth-child(4) .stat-icon-vibrant {
                background: var(--rose-soft);
                color: var(--rose);
            }

            .stat-card-vibrant:nth-child(4):hover {
                border-color: var(--rose);
            }

            .stat-header-vibrant {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .stat-label-vibrant {
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: var(--slate);
            }

            .stat-icon-vibrant {
                width: 42px;
                height: 42px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 19px;
            }

            .stat-value-vibrant {
                font-size: 28px;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 8px;
            }

            .stat-trend-vibrant {
                font-size: 11px;
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--slate);
                padding-top: 8px;
                border-top: 1px solid var(--border);
            }

            .trend-up {
                color: var(--emerald);
            }

            .trend-down {
                color: var(--rose);
            }

            /* Info Cards Row */
            .info-row {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
                margin-bottom: 28px;
            }

            .info-card {
                background: var(--bg-card);
                border-radius: 16px;
                padding: 16px 20px;
                border: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .info-card-content h4 {
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
                color: var(--slate);
                margin: 0 0 4px 0;
            }

            .info-card-content .value {
                font-size: 24px;
                font-weight: 800;
                color: #1e293b;
            }

            .info-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 21px;
            }

            .info-card:nth-child(1) .info-icon {
                background: linear-gradient(135deg, var(--teal), var(--teal-light));
                color: white;
            }

            .info-card:nth-child(2) .info-icon {
                background: linear-gradient(135deg, var(--amber), var(--amber-light));
                color: white;
            }

            .info-card:nth-child(3) .info-icon {
                background: linear-gradient(135deg, var(--indigo), var(--indigo-light));
                color: white;
            }

            /* Main Table Card */
            .table-card-vibrant {
                background: var(--bg-card);
                border-radius: 20px;
                overflow: hidden;
                border: 1px solid var(--admin-border);
                margin-bottom: 1.5rem;
            }

            .table-header-vibrant {
                padding: 20px 24px;
                background: linear-gradient(135deg, #f8fafc, #ffffff);
                border-bottom: 1px solid var(--admin-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 16px;
            }

            .table-title-vibrant {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .table-title-vibrant i {
                font-size: 20px;
                color: var(--primary);
            }

            .table-title-vibrant h4 {
                margin: 0;
                font-size: 18px;
                font-weight: 700;
                color: var(--primary);
            }

            /* Elegant Table */
            .vibrant-table {
                width: 100%;
                border-collapse: collapse;
            }

            .vibrant-table thead th {
                padding: 14px 16px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #4e1620;
                background: #f9fafb;
                border-bottom: 1px solid var(--admin-border);
            }

            .vibrant-table tbody td {
                padding: 16px 19px;
                border-bottom: 1px solid var(--border);
                font-size: 14px;
                color: #334155;
            }

            /* User Info */
            .user-info-vibrant {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .user-avatar-vibrant {
                width: 38px;
                height: 38px;
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 700;
                font-size: 13px;
            }

            .user-name-vibrant {
                font-weight: 700;
                color: #1e293b;
                font-size: 15px;
            }

            .user-email-vibrant {
                font-size: 12px;
                color: var(--slate);
            }

            /* Status Badges */
            .status-vibrant {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 11px;
                font-weight: 700;
                padding: 5px 13px;
                border-radius: 30px;
            }

            .status-verified {
                background: var(--emerald-soft);
                color: var(--emerald);
            }

            .status-pending {
                background: var(--amber-soft);
                color: var(--amber);
            }

            .status-rejected {
                background: #fee2e2;
                color: var(--rose);
            }

            /* Action Buttons */
            .btn-action {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 6px 16px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.2s;
                cursor: pointer;
                border: none;
            }

            .btn-view {
                background: linear-gradient(135deg, var(--indigo), var(--indigo-light));
                color: white;
            }

            .btn-view:hover {
                transform: scale(0.95);
                background: linear-gradient(135deg, var(--indigo-light), var(--indigo));
                color: white;
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 60px 20px;
            }

            .empty-state i {
                font-size: 64px;
                color: var(--slate);
                margin-bottom: 16px;
                opacity: 0.5;
            }

            .empty-state p {
                color: var(--slate);
                margin: 0;
                font-size: 14px;
            }
        </style>

        <div class="verification-container">
            <!-- Page Header -->
            <div class="page-header-vibrant">
                <h1>
                    <i class="fas fa-shield-alt" style="color: var(--primary);"></i>
                    Profile Verification
                </h1>
                <p>Verify user identities and manage document submissions</p>
            </div>

            <!-- Stats Cards -->
            @php
                $totalVerifications = $verifications->count();
                $verifiedCount = $verifications->where('status', 1)->count();
                $pendingCount = $verifications->where('status', 0)->count();
                $rejectedCount = $verifications->where('status', 2)->count();
            @endphp

            <div class="stats-grid-vibrant">
                <!-- Total Verifications - Teal -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Total Verifications</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">{{ $totalVerifications }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-shield-alt"></i>
                        <span>Total requests received</span>
                    </div>
                </div>

                <!-- Verified - Emerald -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Verified</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">{{ $verifiedCount }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-check-circle trend-up"></i>
                        <span
                            class="trend-up">{{ $totalVerifications > 0 ? round(($verifiedCount / $totalVerifications) * 100) : 0 }}%</span>
                        <span>of total</span>
                    </div>
                </div>

                <!-- Pending - Amber -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Pending</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">{{ $pendingCount }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-hourglass-half"></i>
                        <span>Awaiting review</span>
                    </div>
                </div>

                <!-- Rejected - Rose -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Rejected</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">{{ $rejectedCount }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-exclamation-triangle trend-down"></i>
                        <span>Need attention</span>
                    </div>
                </div>
            </div>

            <!-- Main Table Card -->
            <div class="table-card-vibrant">
                <div class="table-header-vibrant">
                    <div class="table-title-vibrant">
                        <i class="fas fa-list-ul"></i>
                        <h4>Verification Requests</h4>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="vibrant-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($verifications as $v)
                                <tr>
                                    <td style="font-weight: 700; color: #4f46e5;">
                                        #{{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="user-info-vibrant">
                                            <div class="user-name-vibrant">{{ $v->name }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-email-vibrant" style="font-size: 13px;">
                                            <i class="fas fa-envelope me-1" style="color: var(--slate);"></i>
                                            {{ $v->email }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($v->status == 1)
                                            <span class="status-vibrant status-verified">
                                                <i class="fas fa-check-circle fa-xs"></i> Verified
                                            </span>
                                        @elseif($v->status == 0)
                                            <span class="status-vibrant status-pending">
                                                <i class="fas fa-clock fa-xs"></i> Pending
                                            </span>
                                        @else
                                            <span class="status-vibrant status-rejected">
                                                <i class="fas fa-times-circle fa-xs"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.view-document', $v->verification_id) }}"
                                            class="btn-action btn-view">
                                            <i class="fas fa-eye fa-xs"></i> View Document
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No verification requests found</p>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide alerts after 5 seconds
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert-vibrant');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
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