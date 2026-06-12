@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

    <!-- ================= STATS ROW ================= -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="ivory-card stat-card">
                <h6>Total Users</h6>
                <h2>{{ $totalUsers }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ivory-card stat-card">
                <h6>Premium Users</h6>
                <h2 class="text-success">
                    {{ $premiumUsers }}
                </h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ivory-card stat-card">
                <h6>Pro Users</h6>
                <h2 class="text-primary">
                    {{ $proUsers }}
                </h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ivory-card stat-card">
                <h6>Total Revenue</h6>
                <h2 class="text-warning">
                    ${{ number_format($totalRevenue, 2) }}
                </h2>
            </div>
        </div>

    </div>


    <!-- ================= VERIFICATION STATS ================= -->
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="ivory-card stat-card">
                <h6>Total Verifications</h6>
                <h2>{{ $verifications->count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ivory-card stat-card">
                <h6>Approved Profiles</h6>
                <h2 class="text-success">
                    {{ $verifications->where('status', 1)->count() }}
                </h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ivory-card stat-card">
                <h6>Rejected Profiles</h6>
                <h2 class="text-danger">
                    {{ $verifications->where('status', 2)->count() }}
                </h2>
            </div>
        </div>

    </div>


    <!-- ================= CHARTS ================= -->
    <div class="row g-4 align-items-stretch">

        <div class="col-md-6 d-flex">
            <div class="ivory-card p-4 w-100 equal-card">
                <h6 class="section-title">User Registrations</h6>
                <div class="chart-box">
                    <canvas id="userRegistrationChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex">
            <div class="ivory-card p-4 w-100 equal-card">
                <h6 class="section-title">Profiles Created</h6>
                <div class="chart-box">
                    <canvas id="profilesCreatedChart"></canvas>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

    <script>

        window.verificationData = [
                        {{ $verifications->where('status', 0)->count() }},
                        {{ $verifications->where('status', 1)->count() }},
            {{ $verifications->where('status', 2)->count() }}
        ];


        window.userRegistrations = {
            labels: [
                @foreach($registrations as $r)
                    "{{ \Carbon\Carbon::create()->month($r->month)->format('M') }}",
                @endforeach
                        ],

            data: [
                @foreach($registrations as $r)
                    {{ $r->total }},
                @endforeach
                        ]
        };


        window.profilesCreated = {
            labels: [
                @foreach($profiles_created as $p)
                    "{{ \Carbon\Carbon::create()->month($p->month)->format('M') }}",
                @endforeach
                        ],

            data: [
                @foreach($profiles_created as $p)
                    {{ $p->total }},
                @endforeach
                        ]
        };

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