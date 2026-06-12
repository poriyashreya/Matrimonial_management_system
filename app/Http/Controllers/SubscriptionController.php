<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;
use Stripe\StripeClient;
use Stripe\Checkout\Session;

class SubscriptionController extends Controller
{
    public function plans()
    {
        Log::info("hi");
        // Fetch active plans
        $plans = Plan::where('status', 1)
            ->orderBy('price', 'asc')
            ->get();

        $rating_status = "nothing";

        $user = auth()->user();

        if ($user) {

            $rating = DB::table('ratings')
                ->where('user_id', $user->id)
                ->latest('updated_at')
                ->first();

            // Never rated before
            if (!$rating) {

                $rating_status = "show";

            } else {

                // User already rated
                if ($rating->status == "rated") {

                    if (
                        Carbon::parse($rating->updated_at)
                            ->lte(now()->subDays(30))
                    ) {

                        $rating_status = "show";

                    } else {

                        $rating_status = "nothing";
                    }
                }

                // User skipped
                elseif ($rating->status == "skipped") {

                    if (
                        Carbon::parse($rating->updated_at)
                            ->lte(now()->subDays(3))
                    ) {

                        $rating_status = "show";

                    } else {

                        $rating_status = "nothing";
                    }
                }

                // User cancelled popup
                elseif ($rating->status == "cancelled") {

                    if (
                        Carbon::parse($rating->updated_at)
                            ->lte(now()->subDays(1))
                    ) {

                        $rating_status = "show";

                    } else {

                        $rating_status = "nothing";
                    }
                } elseif ($rating->status === "pending") {
                    $rating_status = "show";
                }
            }
        }

        return view('subscription.plans', compact('plans', 'rating_status'));
    }

    public function checkout($id)
    {
        $plan = Plan::findOrFail($id);

        $user = auth()->user();

        $subscription = $user->subscription('default');

        // Already subscribed
        if (strtolower($user->plan) === strtolower($plan->name)) {

            return redirect()
                ->route('plans')
                ->with(
                    'error',
                    "You are already subscribed to {$plan->name} plan."
                );
        }

        if ($subscription && $subscription->active()) {

            $currentPlan = Plan::where(
                'stripe_price_id',
                $subscription->stripe_price
            )->first();

            if (
                $currentPlan &&
                strtolower($currentPlan->name) === 'premium' &&
                strtolower($plan->name) === 'pro'
            ) {

                return redirect()
                    ->route(
                        'upgrade.checkout',
                        $plan->id
                    );
            }
        }

        return $user
            ->newSubscription(
                'default',
                $plan->stripe_price_id
            )
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('subscription.cancel'),

                'metadata' => [
                    'upgrade' => false,
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                ],
            ]);
    }

    public function previewUpgrade(Plan $plan)
    {
        try {

            $user = auth()->user();

            $subscription = $user->subscription('default');

            if (!$subscription && strtolower($user->plan) !== 'free') {

                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found.'
                ]);
            }

            $currentPlan = Plan::where(
                'name',
                $user->plan
            )->first();

            if (!$currentPlan) {

                return response()->json([
                    'success' => false,
                    'message' => 'Current plan not found.'
                ]);
            }

            if (strtolower($user->plan) === 'free') {

                return response()->json([
                    'success' => true,
                    'credit' => 0,
                    'amount_due' => $plan->price,
                    'new_plan' => $plan->name,
                ]);
            }


            $startDate = Carbon::parse(
                $subscription->created_at
            );

            $endDate = $startDate->copy()->addMonth();

            $totalDays = $startDate->diffInDays($endDate);

            $remainingDays = max(
                now()->diffInDays($endDate, false),
                0
            );

            $credit =
                ($currentPlan->price / $totalDays)
                * $remainingDays;

            $newPlanCost =
                ($plan->price / $totalDays)
                * $remainingDays;

            $amountDue =
                max($plan->price - $credit, 0);

            if (strtolower($user->plan) === 'free') {

                return response()->json([
                    'success' => true,
                    'credit' => 0,
                    'amount_due' => $plan->price,
                    'new_plan' => $plan->name,
                ]);
            }

            return response()->json([
                'success' => true,
                'credit' => round($credit, 2),
                'amount_due' => round($amountDue, 2),
                'new_plan' => $plan->name,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function upgradeCheckout($id)
    {
        $plan = Plan::findOrFail($id);

        $user = auth()->user();

        $subscription = $user->subscription('default');

        $isplan = $user->plan;

        if (!$isplan) {
            return back()->with('error', 'No active subscription found.');
        }

        $currentPlan = Plan::where(
            'name',
            $user->plan
        )->first();

        if (!$currentPlan) {
            return back()->with('error', 'Current plan not found.');
        }

        if (strtolower($user->plan) === 'free') {

            return redirect()->route(
                'checkout',
                $plan->id
            );
        }

        // Remaining credit calculation
        $startDate = $subscription->created_at;

        $endDate = $startDate->copy()->addMonth();

        $totalDays = $startDate->diffInDays($endDate);

        $remainingDays = max(
            now()->diffInDays($endDate, false),
            0
        );

        $credit =
            ($currentPlan->price / $totalDays)
            * $remainingDays;

        $newPlanCost =
            ($plan->price / $totalDays)
            * $remainingDays;

        $amountDue =
            max($plan->price - $credit, 0);

        $stripe = new StripeClient(config('cashier.secret'));

        \Log::info('Upgrade Calculation', [
            'current_plan_price' => $currentPlan->price,
            'new_plan_price' => $plan->price,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $totalDays,
            'amountDue' => $amountDue,
            'credit' => $credit,
            'newPlanCost' => $newPlanCost,
            'remaining_days' => $remainingDays,
        ]);

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',

            'customer' => $user->stripe_id,

            'success_url' => route('subscription.success'),

            'cancel_url' => route('subscription.cancel'),

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',

                        'product_data' => [
                            'name' =>
                                'Upgrade to ' . $plan->name,
                        ],

                        'unit_amount' =>
                            round($amountDue * 100),
                    ],

                    'quantity' => 1,
                ]
            ],

            'metadata' => [

                'upgrade' => true,

                'user_id' => $user->id,

                'subscription_id' =>
                    $subscription->id,

                'plan_id' =>
                    $plan->id,
            ]
        ]);

        return redirect($session->url);
    }

    public function success()
    {

        $user = auth()->user();

        $pendingPayment = Payment::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subSeconds(5))
            ->latest()
            ->first();

        if (!$pendingPayment) {
            return redirect()
                ->route('plans')
                ->with(
                    'error',
                    'Server is runing low. please try after some times'
                );
        }

        return redirect()
            ->route('plans')
            ->with(
                'info',
                'Thank you. Your payment is in process. We will inform you once completed.'
            );
    }

    public function cancel()
    {
        $user = auth()->user();

        $subscription = $user->subscription('default');

        $pyment = Payment::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->latest()
            ->first();

        if ($subscription) {

            try {

                $subscription->cancelNow();

                $pyment->update([
                    'payment_status' => 'Cancelled',
                ]);

                $user->update([
                    'role' => 'User',
                    'plan' => 'free',
                ]);


            } catch (\Exception $e) {
                return redirect()
                    ->route('profile.myprofile')
                    ->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
            }
        } else {
            return redirect()
                ->route('profile.myprofile')
                ->with('error', 'Failed to cancel subscription Try again later');
        }

        return redirect()
            ->route('profile.myprofile')
            ->with('success', 'Subscription cancelled successfully. If you are eligible for a refund, the amount will be credited to your account within 3-4 business days.');
    }

    public function activateFreePlan(Plan $plan)
    {
        $user = auth()->user();

        // Check if user already has subscription
        if ($user->subscriptions()->where('stripe_status', 'active')->exists()) {
            return back()->with('warning', 'You already have an active higher-tier plan. Upgrade is not required at this time.');
        }

        // Ensure only free plan can use this
        if ($plan->price > 0) {
            return back()->with('error', 'Invalid free plan.');
        }

        // Create local subscription without Stripe
        $user->subscriptions()->create([
            'type' => 'default',
            'stripe_id' => 'free_plan_' . $user->id,
            'stripe_status' => 'active',
            'stripe_price' => $plan->stripe_price_id,
            'quantity' => 1,
        ]);

        return redirect()->route('plans')
            ->with('success', 'Free plan activated successfully.');
    }
}
