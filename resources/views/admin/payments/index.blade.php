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
                margin-bottom: 32px;
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

            /* Search & Filter Section - Updated */
            .search-filter-section {
                padding: 20px 24px;
                background: white;
                border-radius: 16px;
                border: 2px solid var(--admin-border);
                margin-bottom: 32px;
            }

            .search-filter-section .section-title {
                font-size: 16px;
                font-weight: 600;
                color: var(--admin-text);
                margin-bottom: 4px;
            }

            .search-filter-section .section-subtitle {
                font-size: 13px;
                color: var(--admin-text-light);
                margin-bottom: 16px;
            }

            .search-filter-grid {
                display: grid;
                grid-template-columns: 2fr 1fr 1.2fr 1fr auto;
                gap: 16px;
                align-items: end;
            }

            .filter-group {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .filter-group label {
                font-size: 11px;
                font-weight: 600;
                color: var(--admin-text-light);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .filter-group label i {
                margin-right: 4px;
            }

            .filter-group .search-input {
                padding: 10px 14px;
                border: 1px solid var(--admin-border);
                border-radius: 8px;
                font-size: 14px;
                transition: all 0.2s;
                background: white;
                color: var(--admin-text);
                width: 100%;
            }

            .filter-group .search-input:focus {
                outline: none;
                border-color: var(--admin-primary);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .filter-group .search-input::placeholder {
                color: var(--admin-text-light);
                font-size: 13px;
            }

            .filter-group select {
                padding: 10px 14px;
                border: 1px solid var(--admin-border);
                border-radius: 8px;
                font-size: 14px;
                background: white;
                color: var(--admin-text);
                cursor: pointer;
                transition: all 0.2s;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                padding-right: 36px;
                width: 100%;
            }

            .filter-group select:focus {
                outline: none;
                border-color: var(--admin-primary);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .filter-group select option {
                padding: 8px;
            }

            .filter-group input[type="date"] {
                padding: 10px 14px;
                border: 1px solid var(--admin-border);
                border-radius: 8px;
                font-size: 14px;
                transition: all 0.2s;
                background: white;
                color: var(--admin-text);
                width: 100%;
            }

            .filter-group input[type="date"]:focus {
                outline: none;
                border-color: var(--admin-primary);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .filter-actions {
                display: flex;
                gap: 8px;
                align-items: end;
                padding-bottom: 1px;
            }

            .btn-filter-apply {
                background: var(--admin-primary);
                color: white;
                border: none;
                padding: 10px 28px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.2s;
                white-space: nowrap;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .btn-filter-apply:hover {
                background: var(--admin-primary-dark);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            }

            .btn-filter-reset {
                background: white;
                color: var(--admin-text);
                border: 1px solid var(--admin-border);
                padding: 10px 18px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 6px;
                white-space: nowrap;
            }

            .btn-filter-reset:hover {
                background: var(--admin-bg);
                border-color: var(--admin-text-light);
                text-decoration: none;
                color: var(--admin-text);
            }

            /* Active Filter Tags */
            .active-filters-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 16px;
                padding-top: 16px;
                border-top: 1px solid var(--admin-border);
            }

            .filter-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: #eef2ff;
                color: var(--admin-primary);
                padding: 4px 12px 4px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
                border: 1px solid #c7d2fe;
            }

            .filter-tag .remove-filter {
                cursor: pointer;
                font-size: 13px;
                opacity: 0.6;
                transition: all 0.2s;
                margin-left: 2px;
            }

            .filter-tag .remove-filter:hover {
                opacity: 1;
                color: var(--admin-danger);
                transform: scale(1.2);
            }

            .filter-tag.status-paid-tag {
                background: #d1fae5;
                color: #065f46;
                border-color: #10b981;
            }

            .filter-tag.status-refunded-tag {
                background: #fee2e2;
                color: #991b1b;
                border-color: #ef4444;
            }

            .filter-tag.status-cancelled-tag {
                background: #fef3c7;
                color: #92400e;
                border-color: #f59e0b;
            }

            .no-filters-text {
                font-size: 13px;
                color: var(--admin-text-light);
                padding: 4px 0;
            }

            .no-filters-text i {
                margin-right: 6px;
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

            .status-refunded-admin {
                background: #fee2e2;
                color: #991b1b;
            }

            .status-cancelled-admin {
                background: #fef3c7;
                color: #92400e;
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

        <!-- Search & Filter Section -->
            <div class="search-filter-section">
                <div class="section-title">
                    <i class="fas fa-search" style="color: var(--admin-primary); margin-right: 6px;"></i>
                    Search & Filter
                </div>
                <div class="section-subtitle">Refine your payment transactions</div>

                <form method="GET" action="{{ route('admin.payments') }}" id="filterForm">
                    <div class="search-filter-grid">
                        <!-- Search -->
                        <div class="filter-group">
                            <label><i class="fas fa-search"></i> SEARCH</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Name, Email, Transaction ID..."
                                   class="search-input"
                                   id="searchInput">
                        </div>

                        <!-- Status -->
                        <div class="filter-group">
                            <label><i class="fas fa-filter"></i> STATUS</label>
                            <select name="status" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>
                                    Paid
                                </option>
                                <option value="Refunded" {{ request('status') == 'Refunded' ? 'selected' : '' }}>
                                    Refunded
                                </option>
                                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                        </div>

                        <!-- Payment Date -->
                        <div class="filter-group">
                            <label><i class="fas fa-calendar-alt"></i> PAYMENT DATE</label>
                            <input type="date"
                                   name="payment_date"
                                   value="{{ request('payment_date') }}"
                                   class="search-input">
                        </div>

                        <!-- Sort By -->
                        <div class="filter-group">
                            <label><i class="fas fa-sort"></i> SORT BY</label>
                            <select name="sort_by" id="sortFilter">
                                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>
                                    Newest First
                                </option>
                                <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>
                                    Oldest First
                                </option>
                                <option value="amount_asc" {{ request('sort_by') == 'amount_asc' ? 'selected' : '' }}>
                                    Amount Low → High
                                </option>
                                <option value="amount_desc" {{ request('sort_by') == 'amount_desc' ? 'selected' : '' }}>
                                    Amount High → Low
                                </option>
                                <option value="status_asc" {{ request('sort_by') == 'status_asc' ? 'selected' : '' }}>
                                    Status A → Z
                                </option>
                                <option value="status_desc" {{ request('sort_by') == 'status_desc' ? 'selected' : '' }}>
                                    Status Z → A
                                </option>
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter-apply">
                                <i class="fas fa-search"></i> Apply
                            </button>
                            <a href="{{ route('admin.payments') }}" class="btn-filter-reset">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Active Filters Tags -->
                <div class="active-filters-tags">
                    @if(request('search') || request('status') || request('payment_date') || request('sort_by'))
                        @if(request('search'))
                            <span class="filter-tag">
                                "{{ request('search') }}"
                                <span class="remove-filter" onclick="removeFilter('search')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('status'))
                            <span class="filter-tag status-{{ strtolower(request('status')) }}-tag">
                                @if(request('status') == 'Paid')
                                @elseif(request('status') == 'Refunded')
                                @elseif(request('status') == 'Cancelled')
                                @endif
                                {{ request('status') }}
                                <span class="remove-filter" onclick="removeFilter('status')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('payment_date'))
                            <span class="filter-tag">
                                {{ \Carbon\Carbon::parse(request('payment_date'))->format('d M Y') }}
                                <span class="remove-filter" onclick="removeFilter('payment_date')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('sort_by'))
                            <span class="filter-tag">
                                @switch(request('sort_by'))
                                    @case('newest') Newest First
                                    @case('oldest') Oldest First
                                    @case('amount_asc') Amount Low → High
                                    @case('amount_desc') Amount High → Low
                                    @case('status_asc') Status A → Z
                                    @case('status_desc') Status Z → A
                                    @default {{ request('sort_by') }}
                                @endswitch
                                <span class="remove-filter" onclick="removeFilter('sort_by')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif
                    @else
                        <span class="no-filters-text">
                            <i class="fas fa-info-circle"></i>
                            No active filters
                        </span>
                    @endif
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
                                    @elseif($payment->payment_status == 'Refunded')
                                        <span class="status-badge-admin status-refunded-admin">
                                            <i class="fas fa-undo-alt fa-xs" style="font-size: 13px;"></i> Refunded
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

@section('scripts')
    <script>
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit on select change
            const statusFilter = document.getElementById('statusFilter');
            const sortFilter = document.getElementById('sortFilter');
            const filterForm = document.getElementById('filterForm');

            if (statusFilter && sortFilter && filterForm) {
                statusFilter.addEventListener('change', function() {
                    filterForm.submit();
                });

                sortFilter.addEventListener('change', function() {
                    filterForm.submit();
                });

                // Search on Enter key
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    searchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            filterForm.submit();
                        }
                    });
                }
            }
        });
    </script>
@endsection