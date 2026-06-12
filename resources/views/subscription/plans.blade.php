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

                    $userPlan = strtolower($user->plan ?? 'free');
                    $planName = strtolower($plan->name);

                    $isCurrent = $userPlan === $planName;

                    $isPopular = in_array($planName, ['pro', 'premium']);

                    $levels = [
                        'free' => 1,
                        'premium' => 2,
                        'pro' => 3,
                    ];

                    $currentLevel = $levels[$userPlan] ?? 0;
                    $planLevel = $levels[$planName] ?? 0;

                    $isUpgrade = $planLevel > $currentLevel;
                    $isDowngrade = $planLevel < $currentLevel;

                @endphp

                <div class="plan-card {{ $isPopular ? 'popular' : '' }} {{ $isCurrent ? 'current' : '' }}">

                    @if($isPopular && !$isCurrent)
                        <div class="popular-badge">
                            <i class="fas fa-fire"></i>
                            Most Popular
                        </div>
                    @endif

                    @if($isCurrent)
                        <div class="current-badge">
                            <i class="fas fa-check-circle"></i>
                            Current Plan
                        </div>
                    @endif

                    <div class="plan-header">

                        <div class="plan-icon">

                            @if($planName === 'free')
                                <i class="fas fa-user"></i>

                            @elseif($planName === 'pro')
                                <i class="fas fa-star"></i>

                            @else
                                <i class="fas fa-crown"></i>
                            @endif

                        </div>

                        <h3 class="plan-name">
                            {{ $plan->name }}
                        </h3>

                        <div class="plan-price">
                            <span class="price-currency">$</span>
                            <span class="price-amount">
                                {{ number_format($plan->price, 2) }}
                            </span>

                            @if($plan->price > 0)
                                <span class="price-period">/ month</span>
                            @endif
                        </div>

                        @if($plan->price > 0)
                            <div class="price-note">
                                Billed monthly
                            </div>
                        @endif

                    </div>

                    <div class="plan-features">

                        <h4 class="features-title">
                            <i class="fas fa-check-circle"></i>
                            What's included:
                        </h4>

                        <ul class="features-list">

                            @forelse($features as $feature)

                                <li>
                                    <i class="fas fa-check"></i>
                                    <span>{{ $feature }}</span>
                                </li>

                            @empty

                                <li class="text-muted">
                                    No features listed
                                </li>

                            @endforelse

                        </ul>

                    </div>

                    <div class="plan-footer">

                        @if($isCurrent)

                            <button class="btn-current" disabled>
                                <i class="fas fa-check"></i>
                                Active Plan
                            </button>

                        @elseif($planName === 'free')

                            <button class="btn-free opacity-75" disabled>
                                <i class="fas fa-lock"></i>
                                Not Available
                            </button>

                        @elseif($isDowngrade)

                            <button class="btn-subscribe opacity-75" disabled>
                                <i class="fas fa-lock"></i>
                                Not Available
                            </button>

                        @else

                            <button type="button" class="btn-subscribe upgrade-btn" data-plan="{{ $plan->id }}"
                                data-current-plan="{{ $userPlan }}" data-target-plan="{{ $planName }}">

                                @if($isUpgrade)

                                    <i class="fas fa-arrow-up"></i>
                                    Upgrade to {{ $plan->name }}

                                @else

                                    <i class="fas fa-rocket"></i>
                                    Subscribe Now

                                @endif

                            </button>

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

    <script>

        document.querySelectorAll('.upgrade-btn')
            .forEach(button => {

                button.addEventListener('click', function () {

                    let planId =
                        this.dataset.plan;

                    fetch(
                        '/subscription/preview/' + planId,
                        {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}',
                                'Accept':
                                    'application/json'
                            }
                        }
                    )
                        .then(response => response.json())
                        .then(data => {

                            if (!data.success) {

                                Swal.fire(
                                    'Error',
                                    data.message,
                                    'error'
                                );

                                return;
                            }

                            Swal.fire({
                                title: 'Upgrade Plan',

                                html:
                                    '<b>New Plan:</b> '
                                    + data.new_plan
                                    + '<br><br>'

                                    + '<b>Unused Credit:</b> $'
                                    + data.credit.toFixed(2)

                                    + '<br><br>'

                                    + '<b>Amount Due Today:</b> $'
                                    + data.amount_due.toFixed(2),

                                icon: 'info',

                                showCancelButton: true,

                                confirmButtonText:
                                    'Continue'
                            })
                                .then(result => {

                                    if (result.isConfirmed) {

                                        let currentPlan =
                                            button.dataset.currentPlan;

                                        let targetPlan =
                                            button.dataset.targetPlan;

                                        /*
                                        | Premium -> Pro
                                        */
                                        if (
                                            currentPlan === 'premium' &&
                                            targetPlan === 'pro'
                                        ) {

                                            window.location =
                                                '/upgrade/' + planId;
                                        }

                                        /*
                                        | Free -> Premium
                                        | Free -> Pro
                                        */
                                        else {

                                            window.location =
                                                '/checkout/' + planId;
                                        }
                                    }
                                });

                        });

                });

            });

    </script>

@endsection