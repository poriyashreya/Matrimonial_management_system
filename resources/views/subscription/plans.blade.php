@extends('layouts.app')

@section('content')

    @php
        $user = auth()->user();
        $subscription = $user->subscription('default');
    @endphp

    <div class="plans-container">

        <!-- Hero Section -->
        <div class="plans-hero">
            <div class="plans-hero-content">
                <div class="hero-badge">Exclusive Offers</div>
                <h1 class="hero-title1">Choose Your <span class="highlight">Perfect Plan</span></h1>
                <p class="hero-subtitle">Upgrade to unlock premium features and take your experience to the next level</p>
            </div>
        </div>

        <!-- Plans Grid -->
        <div class="plans-grid">

            @foreach($plans as $plan)

                @php
                    $features = json_decode($plan->features, true) ?? [];

                    $isPopular = in_array(strtolower($plan->name), ['pro', 'premium']);

                    if ($plan->name === $user->role) {
                        $isCurrent = true;
                    } else {
                        $isCurrent = false;
                    }
                @endphp

                <div class="plan-card {{ $isPopular ? 'popular' : '' }} {{ $isCurrent ? 'current' : '' }}">

                    @if($isPopular && !$isCurrent)
                        <div class="popular-badge">
                            <i class="fas fa-fire"></i> Most Popular
                        </div>
                    @endif

                    @if($isCurrent)
                        <div class="current-badge">
                            <i class="fas fa-check-circle"></i> Current Plan
                        </div>
                    @endif

                    <div class="plan-header">
                        <div class="plan-icon">
                            @if(strtolower($plan->name) === 'free')
                                <i class="fas fa-user"></i>
                            @elseif(strtolower($plan->name) === 'pro')
                                <i class="fas fa-star"></i>
                            @else
                                <i class="fas fa-crown"></i>
                            @endif
                        </div>

                        <h3 class="plan-name">{{ $plan->name }}</h3>

                        <div class="plan-price">
                            <span class="price-currency">$</span>
                            <span class="price-amount">{{ number_format($plan->price, 2) }}</span>
                            @if($plan->price > 0)
                                <span class="price-period">/ month</span>
                            @endif
                        </div>

                        @if($plan->price > 0)
                            <div class="price-note">Billed monthly</div>
                        @endif
                    </div>

                    <!-- FEATURES -->
                    <div class="plan-features">
                        <h4 class="features-title">
                            <i class="fas fa-check-circle"></i> What's included:
                        </h4>

                        <ul class="features-list">
                            @forelse($features as $feature)
                                <li>
                                    <i class="fas fa-check"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @empty
                                <li class="text-muted">No features listed</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- ACTION BUTTON -->
                    <div class="plan-footer">

                        @if($isCurrent)
                            <button class="btn-current" disabled>
                                <i class="fas fa-check"></i> Active Plan
                            </button>

                        @elseif(strtolower($plan->name) === 'free')
                            <form action="{{ route('free.subscribe', $plan->id) }}" method="POST" class="plan-form">
                                @csrf
                                <button type="submit" class="btn-free">
                                    <i class="fas fa-check"></i> Activate Free Plan
                                </button>
                            </form>

                        @else
                            <a href="{{ route('checkout', $plan->id) }}" class="btn-subscribe">
                                <i class="fas fa-rocket"></i> Subscribe Now
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif

                    </div>
                </div>

            @endforeach

        </div>

        <!-- Trust Badges -->
        <div class="trust-badges">
            <div class="trust-item"><i class="fas fa-lock"></i> Secure Payment</div>
            <div class="trust-item"><i class="fas fa-headset"></i> 24/7 Support</div>
            <div class="trust-item"><i class="fas fa-undo-alt"></i> Cancel Anytime</div>
            <div class="trust-item"><i class="fas fa-shield-alt"></i> Money Back Guarantee</div>
        </div>

    </div>

    <script>
        window.flashData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
        };
    </script>

@endsection