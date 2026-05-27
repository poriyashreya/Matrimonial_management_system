@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<!-- ================= STATS ROW ================= -->
<div class="row g-4 mb-4">

    <div class="col-md-4" data-aos="fade-up">
        <div class="ivory-card stat-card">
            <h6>Total Verifications</h6>
            <h2>{{ $verifications->count() }}</h2>
        </div>
    </div>

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="ivory-card stat-card">
            <h6>Approved Profiles</h6>
            <h2 class="text-success">
                {{ $verifications->where('status',1)->count() }}
            </h2>
        </div>
    </div>

    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="ivory-card stat-card">
            <h6>Rejected Profiles</h6>
            <h2 class="text-danger">
                {{ $verifications->where('status',2)->count() }}
            </h2>
        </div>
    </div>

</div>

<!-- ================= CHARTS ================= -->
<div class="row g-4 align-items-stretch">

    <!-- User Registrations -->
    <div class="col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="100">
        <div class="ivory-card p-4 w-100 equal-card">
            <h6 class="section-title">User Registrations</h6>
            <div class="chart-box">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Profiles Created -->
    <div class="col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="200">
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
        {{ $verifications->where('status',0)->count() }},
        {{ $verifications->where('status',1)->count() }},
        {{ $verifications->where('status',2)->count() }}
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

@endsection
