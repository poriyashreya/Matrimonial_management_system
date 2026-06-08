@extends('admin.layouts.app')

@section('title', 'Subscription Management')
@section('page-title', 'Subscription Management')

@section('content')

    <div class="container-fluid px-4">
        <style>
            /* Fresh & Vibrant Color Scheme */
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

                --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            }

            /* Main Container */
            .subscription-container {
                max-width: 1400px;
                margin: 0 auto;
            }

            /* Page Header */
            .page-header-vibrant {
                margin-bottom: 1.75rem;
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

            /* Stats Grid - Different Colors */
            .stats-grid-vibrant {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.25rem;
                margin-bottom: 1.75rem;
            }

            .stat-card-vibrant {
                background: var(--bg-card);
                border-radius: 20px;
                padding: 1.25rem;
                border: 1px solid var(--border);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .stat-card-vibrant:hover {
                transform: translateY(-6px);
                box-shadow: 0 18px 40px rgba(90, 22, 32, .12);
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
                margin-bottom: 0.75rem;
            }

            .stat-label-vibrant {
                font-size: 0.7rem;
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
                font-size: 1.2rem;
            }

            .stat-value-vibrant {
                font-size: 1.75rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 0.5rem;
            }

            .stat-trend-vibrant {
                font-size: 0.7rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--slate);
                padding-top: 0.5rem;
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
                gap: 1.25rem;
                margin-bottom: 1.75rem;
            }

            .info-card {
                background: var(--bg-card);
                border-radius: 16px;
                padding: 1rem 1.25rem;
                border: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .info-card-content h4 {
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: uppercase;
                color: var(--slate);
                margin: 0 0 0.25rem 0;
            }

            .info-card-content .value {
                font-size: 1.5rem;
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
                font-size: 1.3rem;
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
                border: 1px solid #e5e7eb;
                box-shadow: var(--shadow-sm);
            }

            .table-header-vibrant {
                padding: 1.25rem 1.5rem;
                background: #fafafafa;
                border-bottom: 2px solid #e5e7eb;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .table-title-vibrant {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .table-title-vibrant i {
                font-size: 1.25rem;
                color: var(--primary);
            }

            .table-title-vibrant h4 {
                margin: 0;
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--primary);
            }

            .total-badge-vibrant {
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
                color: white;
                padding: 0.4rem 1rem;
                border-radius: 30px;
                font-size: 0.7rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            /* Elegant Table */
            .vibrant-table {
                width: 100%;
                border-collapse: collapse;
            }

            .vibrant-table thead th {
                padding: 1rem 1.2rem;
                text-align: left;
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #4e1620;
                background: #fafafafa;
                border-bottom: 2px solid #e5e7eb;
            }

            .vibrant-table tbody td {
                padding: 1.25rem 1.2rem;
                border-bottom: 1px solid var(--border);
                font-size: 0.875rem;
                color: #334155;
            }

            /* User Info */
            .user-info-vibrant {
                display: flex;
                align-items: center;
                gap: 0.75rem;
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
                font-size: 0.8rem;
            }

            .user-name-vibrant {
                font-weight: 700;
                color: #1e293b;
                font-size: 16px;
            }

            .user-email-vibrant {
                font-size: 13px;
                color: var(--slate);
            }

            /* Plan Chips - Different Colors */
            .plan-chip-vibrant {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 0.3rem 0.9rem;
                border-radius: 30px;
                font-size: 0.7rem;
                font-weight: 700;
            }

            .chip-premium {
                background: linear-gradient(135deg, #fef3c7, #fde68a);
                color: #92400e;
                border: 1px solid #fbbf24;
            }

            .chip-pro {
                background: linear-gradient(135deg, #dbeafe, #bfdbfe);
                color: #1e40af;
                border: 1px solid #60a5fa;
            }

            .chip-default {
                background: #f1f5f9;
                color: #475569;
                border: 1px solid #cbd5e1;
            }

            /* Amount */
            .amount-vibrant {
                font-weight: 800;
                color: var(--emerald);
                font-size: 0.9rem;
            }

            /* Status Badges */
            .status-vibrant {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 0.7rem;
                font-weight: 700;
                padding: 0.3rem 0.8rem;
                border-radius: 30px;
            }

            .status-active {
                background: var(--emerald-soft);
                color: #065f46 !important;
            }

            .status-cancelled {
                background: #fee2e2;
                color: var(--rose);
            }

            .status-failed {
                background: #fef3c7;
                color: #991b1b;
            }

            /* Date */
            .date-vibrant {
                font-size: 0.75rem;
                color: var(--slate);
                display: flex;
                align-items: center;
                gap: 6px;
            }

            /* Cancel Button */
            .btn-cancel-vibrant {
                background: transparent;
                border: 1px solid #fee2e2;
                padding: 0.35rem 1rem;
                border-radius: 10px;
                font-size: 0.7rem;
                font-weight: 600;
                color: var(--rose);
                transition: all 0.2s;
                cursor: pointer;
            }

            .btn-cancel-vibrant:hover {
                background: #fee2e2;
                border-color: var(--rose);
                transform: scale(0.95);
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
                margin-right: 10px;
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
        </style>

        <div class="subscription-container">
            <!-- Page Header -->
            <div class="page-header-vibrant">
                <h1>
                    <i class="fas fa-credit-card" style="color: var(--primary);"></i>
                    Subscription Management
                </h1>
                <p>Manage and monitor all user subscriptions across the platform</p>
            </div>

            <!-- Stats Grid with Different Colors -->
            <div class="stats-grid-vibrant">
                <!-- Total Revenue - Teal -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Total Revenue</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-arrow-up trend-up"></i>
                        <span class="trend-up">+12.5%</span>
                        <span>from last month</span>
                    </div>
                </div>

                <!-- Premium Users - Amber -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Premium Users</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">{{ $premiumUsers }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-users"></i>
                        <span>Active premium subscribers</span>
                    </div>
                </div>

                <!-- Pro Users - Indigo -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Pro Users</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-rocket"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">{{ $proUsers }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-chart-simple"></i>
                        <span>{{ $proUsers + $premiumUsers }} total subscribers</span>
                    </div>
                </div>

                <!-- Conversion Rate - Rose -->
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Conversion Rate</span>
                        <div class="stat-icon-vibrant">
                            <i class="fas fa-percent"></i>
                        </div>
                    </div>
                    <div class="stat-value-vibrant">68%</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-arrow-up trend-up"></i>
                        <span class="trend-up">+5%</span>
                        <span>improvement</span>
                    </div>
                </div>
            </div>

            <!-- Main Table Card -->
            <div class="table-card-vibrant">
                <div class="table-header-vibrant">
                    <div class="table-title-vibrant">
                        <i class="fas fa-list-ul"></i>
                        <h4>Active Subscriptions</h4>
                    </div>
                    <div class="total-badge-vibrant">
                        <i class="fas fa-chart-simple me-1"></i>
                        Total: {{ $subscriptions->total() }} subscriptions
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="vibrant-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Purchase Date</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscriptions as $i => $subscription)
                                <tr>
                                    <td style="font-weight: 700; color: #4f46e5;">
                                        #{{ $i + $subscriptions->firstItem() }}
                                    </td>
                                    <td>
                                        <div class="user-info-vibrant">
                                            <div>
                                                <div class="user-name-vibrant">{{ $subscription->user->name ?? 'N/A' }}</div>
                                                <div class="user-email-vibrant">{{ $subscription->user->email ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($subscription->plan)
                                            @if($subscription->plan->name == 'Premium')
                                                <span class="plan-chip-vibrant chip-premium">
                                                    <i class="fas fa-crown fa-xs"></i> Premium
                                                </span>
                                            @elseif($subscription->plan->name == 'Pro')
                                                <span class="plan-chip-vibrant chip-pro">
                                                    <i class="fas fa-bolt fa-xs"></i> Pro
                                                </span>
                                            @else
                                                <span class="plan-chip-vibrant chip-default">
                                                    <i class="fas fa-tag fa-xs"></i> {{ $subscription->plan->name }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="plan-chip-vibrant chip-default">
                                                <i class="fas fa-question fa-xs"></i> No Plan
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="amount-vibrant">${{ number_format($subscription->amount, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($subscription->payment_status == 'Paid')
                                            <span class="status-vibrant status-active">
                                                <i class="fas fa-check-circle fa-xs"></i> Active
                                            </span>
                                        @elseif($subscription->payment_status == 'Cancelled')
                                            <span class="status-vibrant status-cancelled">
                                                <i class="fas fa-times-circle fa-xs"></i> Cancelled
                                            </span>
                                        @else
                                            <span class="status-vibrant status-failed">
                                                <i class="fas fa-exclamation-triangle fa-xs"></i> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="date-vibrant">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($subscription->purchase_date)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-vibrant">
                                            <i class="far fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($subscription->expiry_date)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($subscription->payment_status == 'Paid')
                                            <form method="POST" action="{{ route('admin.subscription.cancel', $subscription->id) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="button" class="btn-cancel-vibrant cancel-btn">
                                                    <i class="fas fa-ban me-1"></i> Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="status-vibrant status-cancelled">
                                                <i class="fas fa-ban"></i> Cancelled
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">No subscriptions found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($subscriptions->hasPages())
                    <div class="pagination-wrapper-admin d-flex justify-content-between align-items-center">

                        <div class="pagination-info-admin">
                            <i class="fas fa-chart-simple me-1"></i>
                            Showing {{ $subscriptions->firstItem() }} to {{ $subscriptions->lastItem() }}
                            of {{ $subscriptions->total() }} results
                        </div>

                        <div class="pagination-links-admin">
                            {{ $subscriptions->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                @endif
            </div>
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

            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    let form = this.closest('form');

                    Swal.fire({
                        title: 'Cancel Subscription?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, cancel it',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Processing...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                    form.submit();
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection