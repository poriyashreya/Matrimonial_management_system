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

            /* Search & Filter Section - Updated */
            .search-filter-section {
                padding: 20px 24px;
                background: white;
                border: 2px solid var(--admin-border);
                border-radius: 16px;
                margin-bottom: 24px;
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
                grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto;
                gap: 14px;
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

            .filter-tag.plan-free-tag {
                background: #eef2ff;
                color: var(--admin-primary);
                border-color: #c7d2fe;
            }

            .filter-tag.plan-premium-tag {
                background: #d1fae5;
                color: #065f46;
                border-color: #10b981;
            }

            .filter-tag.plan-pro-tag {
                background: #fed7aa;
                color: #92400e;
                border-color: #f59e0b;
            }

            .filter-tag.status-active-tag {
                background: #d1fae5;
                color: #065f46;
                border-color: #10b981;
            }

            .filter-tag.status-inactive-tag {
                background: #f3f4f6;
                color: #6b7280;
                border-color: #d1d5db;
            }

            .filter-tag.status-banned-tag {
                background: #fee2e2;
                color: #991b1b;
                border-color: #ef4444;
            }

            .filter-tag.role-admin-tag {
                background: #eef2ff;
                color: var(--admin-primary);
                border-color: #c7d2fe;
            }

            .filter-tag.role-user-tag {
                background: #f3f4f6;
                color: #6b7280;
                border-color: #d1d5db;
            }

            .no-filters-text {
                font-size: 13px;
                color: var(--admin-text-light);
                padding: 4px 0;
            }

            .no-filters-text i {
                margin-right: 6px;
            }

            /* Responsive */
            @media (max-width: 1200px) {
                .search-filter-grid {
                    grid-template-columns: 1fr 1fr 1fr;
                }
            }

            @media (max-width: 992px) {
                .search-filter-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 768px) {
                .search-filter-grid {
                    grid-template-columns: 1fr;
                }

                .filter-actions {
                    flex-direction: column;
                    width: 100%;
                }

                .btn-filter-apply,
                .btn-filter-reset {
                    width: 100%;
                    justify-content: center;
                }

                .search-filter-section {
                    padding: 16px;
                }

                .stats-row {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 480px) {
                .stats-row {
                    grid-template-columns: 1fr;
                }
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
        <div class="stats-row">
            <!-- Total Users -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value">{{ $users->total() ?? count($users) }}</div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-chart-line"></i>
                    <span>All registered users</span>
                </div>
            </div>

            <!-- Active Users -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Active</div>
                        <div class="stat-value" style="color: var(--admin-success);">
                            {{ $users->where('is_active', 1)->where('status', '!=', 'banned')->count() }}
                        </div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-user-check"></i>
                    <span>Active users</span>
                </div>
            </div>

            <!-- Banned Users -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Banned</div>
                        <div class="stat-value" style="color: var(--admin-danger);">
                            {{ $users->where('status', 'banned')->count() }}
                        </div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-ban"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-gavel"></i>
                    <span>Banned users</span>
                </div>
            </div>

            <!-- Admins -->
            <div class="stat-card-admin">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Admins</div>
                        <div class="stat-value" style="color: var(--admin-primary);">
                            {{ $users->where('role', 'admin')->count() }}
                        </div>
                    </div>
                    <div class="stat-icon-admin">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <i class="fas fa-crown"></i>
                    <span>Administrators</span>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
            <div class="search-filter-section">
                <div class="section-title">
                    <i class="fas fa-search" style="color: var(--admin-primary); margin-right: 6px;"></i>
                    Search & Filter
                </div>
                <div class="section-subtitle">Refine your user search</div>

                <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm">
                    <div class="search-filter-grid">
                        <!-- Search -->
                        <div class="filter-group">
                            <label><i class="fas fa-search"></i> SEARCH</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search by name or email..."
                                   class="search-input"
                                   id="searchInput">
                        </div>

                        <!-- Plan Filter -->
                        <div class="filter-group">
                            <label><i class="fas fa-crown"></i> PLAN</label>
                            <select name="plan" id="planFilter">
                                <option value="">All Plans</option>
                                <option value="free" {{ request('plan') == 'free' ? 'selected' : '' }}>
                                    Free
                                </option>
                                <option value="premium" {{ request('plan') == 'premium' ? 'selected' : '' }}>
                                    Premium
                                </option>
                                <option value="pro" {{ request('plan') == 'pro' ? 'selected' : '' }}>
                                    Pro
                                </option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="filter-group">
                            <label><i class="fas fa-filter"></i> STATUS</label>
                            <select name="status" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                                <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>
                                    Banned
                                </option>
                            </select>
                        </div>

                        <!-- Role Filter -->
                        <div class="filter-group">
                            <label><i class="fas fa-user-tag"></i> ROLE</label>
                            <select name="role" id="roleFilter">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>
                                    User
                                </option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="filter-group">
                            <label><i class="fas fa-sort"></i> SORT BY</label>
                            <select name="sort" id="sortFilter">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                    Newest First
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    Oldest First
                                </option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                    Name A-Z
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                    Name Z-A
                                </option>
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter-apply">
                                <i class="fas fa-search"></i> Apply
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn-filter-reset">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Active Filters Tags -->
                <div class="active-filters-tags">
                    @if(request('search') || request('plan') || request('status') || request('role') || request('sort'))
                        @if(request('search'))
                            <span class="filter-tag">
                                🔍 "{{ request('search') }}"
                                <span class="remove-filter" onclick="removeFilter('search')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('plan'))
                            <span class="filter-tag plan-{{ request('plan') }}-tag">
                                @if(request('plan') == 'free')
                                @elseif(request('plan') == 'premium')
                                @elseif(request('plan') == 'pro')
                                @endif
                                {{ ucfirst(request('plan')) }}
                                <span class="remove-filter" onclick="removeFilter('plan')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('status'))
                            <span class="filter-tag status-{{ request('status') }}-tag">
                                @if(request('status') == 'active')
                                @elseif(request('status') == 'inactive')
                                @elseif(request('status') == 'banned')
                                @endif
                                {{ ucfirst(request('status')) }}
                                <span class="remove-filter" onclick="removeFilter('status')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('role'))
                            <span class="filter-tag role-{{ request('role') }}-tag">
                                @if(request('role') == 'admin')
                                @elseif(request('role') == 'user')
                                @endif
                                {{ ucfirst(request('role')) }}
                                <span class="remove-filter" onclick="removeFilter('role')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('sort'))
                            <span class="filter-tag">
                                @switch(request('sort'))
                                    @case('latest') Newest First
                                    @case('oldest') Oldest First
                                    @case('name_asc') Name A-Z
                                    @case('name_desc') Name Z-A
                                    @default {{ request('sort') }}
                                @endswitch
                                <span class="remove-filter" onclick="removeFilter('sort')">
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
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit on select change
            const planFilter = document.getElementById('planFilter');
            const statusFilter = document.getElementById('statusFilter');
            const roleFilter = document.getElementById('roleFilter');
            const sortFilter = document.getElementById('sortFilter');
            const filterForm = document.getElementById('filterForm');

            if (planFilter && statusFilter && roleFilter && sortFilter && filterForm) {
                planFilter.addEventListener('change', function() {
                    filterForm.submit();
                });

                statusFilter.addEventListener('change', function() {
                    filterForm.submit();
                });

                roleFilter.addEventListener('change', function() {
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