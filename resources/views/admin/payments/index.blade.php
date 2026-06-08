@extends('admin.layouts.app')

@section('title', 'Payment Management')
@section('page-title', 'Payment Management')

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

            .page-header-wrapper {
                background: var(--admin-header);
                border-radius: 16px;
                padding: 1.5rem 2rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--admin-border);
            }

            .page-header-wrapper h1 {
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--admin-text);
                margin-bottom: 0.25rem;
            }

            .page-header-wrapper p {
                color: var(--admin-text-light);
                font-size: 0.875rem;
                margin: 0;
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

            .stats-row {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
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

            .trend-up {
                color: var(--admin-success);
            }

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

            /* Buttons - Matching sidebar buttons */
            .btn-admin-outline {
                background: white;
                border: 1px solid var(--admin-border);
                border-radius: 8px;
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
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
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
                font-weight: 500;
                color: white;
                transition: all 0.2s;
                cursor: pointer;
            }

            .btn-admin-primary:hover {
                background: var(--admin-primary-dark);
            }

            /* Table Styles */
            .payment-table-admin {
                width: 100%;
                border-collapse: collapse;
            }

            .payment-table-admin thead th {
                padding: 0.875rem 1rem;
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: var(--admin-text-light);
                background: #f9fafb;
                border-bottom: 1px solid var(--admin-border);
            }

            .payment-table-admin tbody td {
                padding: 1rem;
                font-size: 0.875rem;
                color: var(--admin-text);
                border-bottom: 1px solid var(--admin-border);
                vertical-align: middle;
            }

            .payment-table-admin tbody tr {
                transition: background 0.2s;
            }

            .payment-table-admin tbody tr:hover {
                background: #f9fafb;
            }

            /* User Info */
            .user-info-admin {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .user-avatar-admin {
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
                font-size: 16px;
                color: var(--admin-text);
                margin-bottom: 2px;
            }

            .user-email {
                font-size: 13px;
                color: var(--admin-text-light);
            }

            /* Plan Badge */
            .plan-badge-admin {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 10px;
                background: #eef2ff;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
                color: var(--admin-primary);
            }

            /* Amount */
            .amount-admin {
                font-weight: 700;
            }

            .amount-success {
                color: var(--admin-success);
            }

            .amount-cancelled {
                color: var(--admin-text-light);
                text-decoration: line-through;
            }

            /* Transaction ID */
            .transaction-id-admin {
                font-family: monospace;
                font-size: 0.7rem;
                background: #f3f4f6;
                padding: 4px 8px;
                border-radius: 6px;
                color: var(--admin-text-light);
                display: inline-block;
            }

            /* Status Badges */
            .status-badge-admin {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
            }

            .status-paid-admin {
                background: #d1fae5;
                color: #065f46 !important;
            }

            .status-cancelled-admin {
                background: #fee2e2;
                color: #991b1b;
            }

            /* Date */
            .date-admin {
                font-size: 0.75rem;
                color: var(--admin-text-light);
            }

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

            /* Responsive */
            @media (max-width: 968px) {
                .stats-row {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                }

                .card-header-admin {
                    flex-direction: column;
                    align-items: stretch;
                }
            }
        </style>

        <!-- Page Header -->
        <div class="page-header-wrapper">
            <div class="secure-badge">
                <i class="fas fa-shield-alt me-1"></i> SECURE TRANSACTIONS
            </div>
            <h1>
                <i class="fas fa-chart-pie me-2"></i>
                Payment Management
            </h1>
            <p>Monitor and manage all financial activities across the platform</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-row">
            <!-- Total Revenue -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-arrow-up trend-up"></i>
                    <span class="trend-up">+12.5%</span>
                    <span>from last month</span>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Transactions</div>
                        <div class="stat-value">{{ $payments->total() }}</div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Lifetime payments</span>
                </div>
            </div>

            <!-- Successful Payments -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Successful Payments</div>
                        <div class="stat-value">{{ $payments->where('payment_status', 'Paid')->count() }}</div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    @php
                        $total = $payments->total();
                        $successful = $payments->where('payment_status', 'Paid')->count();
                        $percentage = $total > 0 ? round(($successful / $total) * 100, 1) : 0;
                    @endphp
                    <i class="fas fa-chart-simple"></i>
                    <span>{{ $percentage }}% success rate</span>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="main-card-admin">
            <div class="card-header-admin">
                <div>
                    <h5>
                        <i class="fas fa-clock"></i>
                        Recent Transactions
                    </h5>
                    <p>Complete list of all payment transactions</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="payment-table-admin">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Transaction ID</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $i => $payment)
                            <tr>
                                <td class="fw-semibold" style="color: var(--admin-primary);">
                                    #{{ $i + $payments->firstItem() }}
                                </td>
                                <td>
                                    <div class="user-info-admin">
                                        <div>
                                            <div class="user-name">{{ $payment->user->name ?? 'Shreya Poriya' }}</div>
                                            <div class="user-email">{{ $payment->user->email ?? 'shreya09@gmail.com' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="plan-badge-admin">
                                        <i class="fas fa-crown fa-xs"></i>
                                        {{ $payment->plan->name ?? 'Pro' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="amount-admin {{ $payment->payment_status == 'Paid' ? 'amount-success' : 'amount-cancelled' }}">
                                        ${{ number_format($payment->amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <code class="transaction-id-admin">
                                                                                                                                                                        {{ substr($payment->stripe_payment_id ?? 'stripe-session', 0, 12) }}...
                                                                                                                                                                    </code>
                                </td>
                                <td>
                                    @if($payment->payment_status == 'Paid')
                                        <span class="status-badge-admin status-paid-admin">
                                            <i class="fas fa-check-circle fa-xs" style="font-size: 13px;"></i> Paid
                                        </span>
                                    @else
                                        <span class="status-badge-admin status-cancelled-admin">
                                            <i class="fas fa-times-circle fa-xs" style="font-size: 13px;"></i> Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="date-admin">
                                        {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}
                                        <br>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($payment->paid_at)->format('h:i A') }}</small>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">No payments found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
                <div class="pagination-wrapper-admin">
                    <div class="pagination-info-admin">
                        <i class="fas fa-chart-simple me-1"></i>
                        Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} results
                    </div>
                    <div class="pagination-links-admin">
                        {{ $payments->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    

@endsection