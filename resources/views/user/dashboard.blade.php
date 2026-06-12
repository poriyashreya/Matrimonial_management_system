@extends('layouts.app')

@section('content')
    {{-- HERO --}}
    <section class="hero-elegant">
        <div class="container">
            <div class="row align-items-center">
                <!-- TEXT -->
                <div class="col-lg-6">
                    <span class="hero-badge">
                        💍 Trusted Matrimonial Platform
                    </span>

                    <h1 class="hero-title">
                        Find Love That<br>
                        <span>Lasts Forever</span>
                    </h1>

                    <p class="hero-text">
                        Connecting hearts with verified profiles, secure privacy,
                        and meaningful matches crafted just for you.
                    </p>

                    <a href="{{ route('matches.show') }}" class="btn app-btn-primary">
                        Browse Matches
                    </a>

                </div>

                <!-- IMAGE -->
                <div class="col-lg-6 text-center">
                    <div class="hero-image-wrapper">
                        <img src="{{ asset('images/couple2.jpeg') }}" alt="Happy Couple"
                            style="height: 600px; width: 400px;">
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- FEATURED PROFILES --}}
    <section class="profiles-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h3>Featured Profiles</h3>
            </div>

            <div class="row g-4">
                @forelse($profiles as $profile)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="profile-card-modern">
                                <div class="profile-img-wrapper">
                                    <img src="{{ $profile->images->first()
                    ? Storage::url($profile->images->first()->file_path)
                    : 'https://via.placeholder.com/300' }}">

                                    @if($profile->is_premium)
                                        <span class="premium-badge">Premium</span>
                                    @endif
                                </div>

                                <div class="profile-info">
                                    <h5>{{ $profile->user->name }}, {{ $profile->age }}</h5>
                                    <p>{{ $profile->profession }}</p>

                                    <div class="profile-tags mb-3">
                                        <span>{{ $profile->religion }}</span>
                                        <span>{{ $profile->community }}</span>
                                    </div>

                                    <a href="{{ route('user.show', ['id' => $profile->id, 'page' => 'dashboard']) }}"
                                        class="btn btn-view-modern">
                                        View Profile
                                    </a>
                                    <div class="mb-3"></div>
                                </div>
                            </div>
                        </div>
                @empty
                    <p class="text-center text-muted">No profiles available.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Counters --}}
    <section class="counters-section py-5 bg-light">
        <div class="container">
            <div class="row text-center g-4">

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="200000">0</h2>
                        <p>Verified Profiles</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="5000">0</h2>
                        <p>Happy Couples</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="100">0</h2>
                        <p>Privacy Secured</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="24">0</h2>
                        <p>Support Hours</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- SUCCESS STORIES --}}
    <section class="success-stories-modern py-5">
        <!-- Header + Add Button -->
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-5">
                <div>
                    <h4 class="stories-title mb-1">Love Stories That Inspire</h4>
                    <p class="stories-subtitle mb-0 text-muted">
                        Real journeys of couples who found their forever here
                    </p>
                </div>

                @auth
                    <a href="{{ route('testimonial.create') }}"
                        class="btn btn-add px-4 py-1 rounded-4 shadow-sm d-flex align-items-center">
                        <span class="fs-4 pe-1">+ </span> Add Your Success Story
                    </a>
                @endauth
            </div>
        </div>

        @if($testimonials->isEmpty())
            <p class="text-center text-muted">No testimonials available</p>
        @else
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

                <div class="carousel-inner">
                    <div class="container">

                        @foreach($testimonials->chunk(3) as $chunkIndex => $testimonialChunk)
                            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                <div class="row justify-content-center g-4">

                                    @foreach($testimonialChunk as $story)
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="story-card-modern p-4 shadow-lg rounded-4 position-relative h-100">
                                                        <!-- Quote Icon -->
                                                        <div class="quote-icon position-absolute">“</div>

                                                        <!-- Message -->
                                                        <p class="story-text text-dark mt-3">
                                                            {{ $story->message }}
                                                        </p>

                                                        <!-- User Info -->
                                                        <div class="story-user d-flex align-items-center mt-4">
                                                            <img src="{{ $story->image
                                        ? Storage::url($story->image)
                                        : asset('images/default-couple.jpg') }}"
                                                                class="rounded-circle me-3 border border-2 border-white shadow-sm" width="60"
                                                                height="60" alt="Couple Image">

                                                            <div>
                                                                <strong class="d-block">{{ $story->couple_name }}</strong>
                                                                <span class="text-muted">{{ $story->status }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Indicators -->
                <div class="carousel-indicators">
                    @foreach($testimonials->chunk(3) as $chunkIndex => $chunk)
                        <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $chunkIndex }}"
                            class="{{ $chunkIndex == 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
            </div>
        @endif

    </section>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.counter').forEach(counter => {
                const target = +counter.dataset.count;
                const speed = target / 200;

                const update = () => {
                    const count = +counter.innerText;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + speed);
                        setTimeout(update, 10);
                    } else {
                        counter.innerText = target;
                    }
                };
                update();
            });
        });
    </script>

    <!-- sweetalert -->

    <script>
        window.routes = {
            rate: "{{ route('rating.store') }}",
            skip: "{{ route('rating.skip') }}",
            cancel: "{{ route('rating.cancel') }}"
        };

        window.ratingData = {
            status: @json($rating_status ?? 'nothing')
        };
    </script>
    <script>
        window.flashData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
        };
    </script>
@endsection