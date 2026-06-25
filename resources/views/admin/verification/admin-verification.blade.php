@extends('admin.layouts.app')

@section('title', 'Verify Profiles')
@section('page-title', 'Profile Verification')

@section('content')

    <div class="container-fluid px-4">
        <style>
            /* ─── Fresh & Vibrant Color Scheme ─── */
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

                --admin-primary: #4f46e5;
                --admin-primary-dark: #4338ca;
                --admin-primary-light: #6366f1;

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

            /* ─── Main Container ─── */
            .verification-container {
                max-width: 1400px;
                margin: 0 auto;
            }

            /* ─── Page Header ─── */
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

            /* ─── Stats Grid ─── */
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

            .stat-card-vibrant:nth-child(1) .stat-icon-vibrant {
                background: var(--teal-soft);
                color: var(--teal);
            }

            .stat-card-vibrant:nth-child(1):hover {
                border-color: var(--teal);
            }

            .stat-card-vibrant:nth-child(2) .stat-icon-vibrant {
                background: var(--amber-soft);
                color: var(--amber);
            }

            .stat-card-vibrant:nth-child(2):hover {
                border-color: var(--amber);
            }

            .stat-card-vibrant:nth-child(3) .stat-icon-vibrant {
                background: var(--indigo-soft);
                color: var(--indigo);
            }

            .stat-card-vibrant:nth-child(3):hover {
                border-color: var(--indigo);
            }

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

            /* ─── Search & Filter Section ─── */
            .search-filter-section {
                padding: 20px 24px;
                background: white;
                border-bottom: 1px solid var(--admin-border);
                border-radius: 20px;
                border: 1px solid var(--admin-border);
                margin-bottom: 28px;
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
                grid-template-columns: 2fr 1fr 1fr auto;
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

            /* ─── Active Filter Tags ─── */
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

            .filter-tag.status-verified-tag {
                background: #d1fae5;
                color: #065f46;
                border-color: #10b981;
            }

            .filter-tag.status-pending-tag {
                background: #fef3c7;
                color: #92400e;
                border-color: #f59e0b;
            }

            .filter-tag.status-rejected-tag {
                background: #fee2e2;
                color: #991b1b;
                border-color: #ef4444;
            }

            .no-filters-text {
                font-size: 13px;
                color: var(--admin-text-light);
                padding: 4px 0;
            }

            .no-filters-text i {
                margin-right: 6px;
            }

            /* ─── Table Card ─── */
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

            /* ─── Responsive ─── */
            @media (max-width: 1200px) {
                .search-filter-grid {
                    grid-template-columns: 1fr 1fr 1fr;
                }
            }

            @media (max-width: 992px) {
                .search-filter-grid {
                    grid-template-columns: 1fr 1fr;
                }

                .stats-grid-vibrant {
                    grid-template-columns: repeat(2, 1fr);
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

                .stats-grid-vibrant {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 480px) {
                .stats-grid-vibrant {
                    grid-template-columns: 1fr;
                }
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
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Total Verifications</span>
                        <div class="stat-icon-vibrant"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-value-vibrant">{{ $totalVerifications }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-shield-alt"></i>
                        <span>Total requests received</span>
                    </div>
                </div>
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Verified</span>
                        <div class="stat-icon-vibrant"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="stat-value-vibrant">{{ $verifiedCount }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-check-circle trend-up"></i>
                        <span
                            class="trend-up">{{ $totalVerifications > 0 ? round(($verifiedCount / $totalVerifications) * 100) : 0 }}%</span>
                        <span>of total</span>
                    </div>
                </div>
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Pending</span>
                        <div class="stat-icon-vibrant"><i class="fas fa-clock"></i></div>
                    </div>
                    <div class="stat-value-vibrant">{{ $pendingCount }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-hourglass-half"></i>
                        <span>Awaiting review</span>
                    </div>
                </div>
                <div class="stat-card-vibrant">
                    <div class="stat-header-vibrant">
                        <span class="stat-label-vibrant">Rejected</span>
                        <div class="stat-icon-vibrant"><i class="fas fa-times-circle"></i></div>
                    </div>
                    <div class="stat-value-vibrant">{{ $rejectedCount }}</div>
                    <div class="stat-trend-vibrant">
                        <i class="fas fa-exclamation-triangle trend-down"></i>
                        <span>Need attention</span>
                    </div>
                </div>
            </div>

            <!-- ─── SEARCH & FILTER SECTION ─── -->
            <div class="search-filter-section">
                <div class="section-title">
                    <i class="fas fa-search" style="color: var(--admin-primary); margin-right: 6px;"></i>
                    Search & Filter
                </div>
                <div class="section-subtitle">Refine your verification requests</div>

                <form method="GET" action="{{ route('admin.verifications') }}" id="filterForm">
                    <div class="search-filter-grid">
                        <!-- Search -->
                        <div class="filter-group">
                            <label><i class="fas fa-search"></i> SEARCH</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search by name, email or document..."
                                   class="search-input"
                                   id="searchInput">
                        </div>

                        <!-- Status -->
                        <div class="filter-group">
                            <label><i class="fas fa-filter"></i> STATUS</label>
                            <select name="status" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                                    Verified
                                </option>
                                <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="filter-group">
                            <label><i class="fas fa-sort"></i> SORT BY</label>
                            <select name="sort" id="sortFilter">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
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
                                <option value="verified" {{ request('sort') == 'verified' ? 'selected' : '' }}>
                                    Verified First
                                </option>
                                <option value="pending" {{ request('sort') == 'pending' ? 'selected' : '' }}>
                                    Pending First
                                </option>
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="filter-actions">
                            <button type="submit" class="btn-filter-apply">
                                <i class="fas fa-search"></i> Apply
                            </button>
                            <a href="{{ route('admin.verifications') }}" class="btn-filter-reset">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Active Filters Tags -->
                <div class="active-filters-tags">
                    @if(request('search') || request('status') !== null || request('sort'))
                        @if(request('search'))
                            <span class="filter-tag">
                                🔍 "{{ request('search') }}"
                                <span class="remove-filter" onclick="removeFilter('search')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('status') !== null && request('status') !== '')
                            <span class="filter-tag status-{{ request('status') == 1 ? 'verified' : (request('status') == 0 ? 'pending' : 'rejected') }}-tag">
                                @if(request('status') == 1) ✅
                                @elseif(request('status') == 0) ⏳
                                @elseif(request('status') == 2) ❌
                                @endif
                                {{ request('status') == 1 ? 'Verified' : (request('status') == 0 ? 'Pending' : 'Rejected') }}
                                <span class="remove-filter" onclick="removeFilter('status')">
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        @endif

                        @if(request('sort'))
                            <span class="filter-tag">
                                📊
                                @switch(request('sort'))
                                    @case('newest') Newest First
                                    @case('oldest') Oldest First
                                    @case('name_asc') Name A-Z
                                    @case('name_desc') Name Z-A
                                    @case('verified') Verified First
                                    @case('pending') Pending First
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

            <!-- Table Card -->
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
                                    <td style="font-weight: 700; color: #4f46e5;">#{{ $loop->iteration }}</td>
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