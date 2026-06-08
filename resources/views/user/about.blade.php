@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <style>
        .cta-section {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 20px 20px;
            color: #fff;
        }
    </style>

    <!-- HERO -->
    <section class="py-5 text-white" style="background: linear-gradient(135deg, #7a1f28, #b8323a); margin-top: -2%;">
        <div class="container text-center">
            <h1 class="fw-bold mb-2">About Us</h1>
            <p class="lead mb-0">Connecting hearts • Building lifelong relationships</p>
        </div>
    </section>



    <!-- ABOUT INTRO -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3">Who We Are</h2>
                    <p class="text-muted" style="text-align:justify">
                        We are a trusted matrimonial platform dedicated to helping individuals find
                        meaningful and lifelong relationships. Our goal is to blend tradition with
                        technology to create genuine connections based on compatibility, values,
                        and trust.
                    </p>
                    <p class="text-muted" style="text-align:justify">
                        Thousands of successful matches have begun their journey with us — and we
                        continue to grow with honesty, security, and care at our core.
                    </p>
                </div>

                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/mission1.jpg') }}" class="img-fluid rounded-4 shadow" alt="About Us">
                </div>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose Us?</h2>
                <p class="text-muted">We make your search simple, safe, and meaningful</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                        <div class="fs-1 text-danger mb-3">❤️</div>
                        <h5 class="fw-semibold">Genuine Profiles</h5>
                        <p class="text-muted small">
                            Every profile is verified to ensure authenticity and trust.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                        <div class="fs-1 text-danger mb-3">🔒</div>
                        <h5 class="fw-semibold">Privacy First</h5>
                        <p class="text-muted small">
                            Your personal information stays secure and under your control.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                        <div class="fs-1 text-danger mb-3">🤝</div>
                        <h5 class="fw-semibold">Smart Matching</h5>
                        <p class="text-muted small">
                            Intelligent matching based on preferences, values, and lifestyle.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="text-center text-white py-5" style="background: linear-gradient(135deg, #7a1f28, #b8323a);">
        <div class="cta-section mx-3">
            <div class="container py-5">
                <h2 class="fw-bold mb-2">Start Your Journey With Us</h2>
                <p class="mb-4">
                    Create your profile today and take the first step towards your future.
                </p>

                @if(!auth()->user()->profile)
                    <a href="{{ route('profile.create') }}" class="btn btn-light fw-semibold px-4 py-2">
                        Complete Your Profile
                    </a>
                @else
                    <a href="{{ route('matches.show') }}" class="btn btn-light fw-semibold px-4 py-2">
                        Explore your matches
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- OUR MISSION -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6 order-md-2">
                    <h2 class="fw-bold mb-3">Our Mission</h2>
                    <p class="text-muted" style="text-align:justify">
                        Our mission is to help individuals find meaningful relationships that lead
                        to happy marriages. We strive to provide a respectful, inclusive, and
                        secure environment where love can grow naturally.
                    </p>
                    <ul class="text-muted">
                        <li>Promote genuine connections</li>
                        <li>Respect cultural values</li>
                        <li>Ensure privacy & safety</li>
                        <li>Support users at every step</li>
                    </ul>
                </div>

                <div class="col-md-6 order-md-1 text-center">
                    <img src="{{ asset('images/mission3.jpg') }}" class="img-fluid rounded-4 shadow" alt="Our Mission">
                </div>
            </div>
        </div>
    </section>

    <script>
        window.ratingData = {
            status: @json($rating_status)
        };
    </script>

    <script>
        window.routes = {
            rate: "{{ route('rating.store') }}",
            skip: "{{ route('rating.skip') }}"
        };

        window.ratingData = {
            status: @json($rating_status)
        };

        console.log(window.routes);
    </script>


@endsection