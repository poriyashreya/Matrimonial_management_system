<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function plans()
    {
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

        if ($user->role === $plan->name) {

            return redirect()
                ->route('plans')
                ->with(
                    'error',
                    "You already subscribed to {$plan->name} plan."
                );
        }

        if (
            strtolower($user->role) === 'pro' &&
            strtolower($plan->name) === 'premium'
        ) {

            return redirect()
                ->route('plans')
                ->with(
                    'error',
                    'You already have a higher plan.'
                );
        }

        return $user
            ->newSubscription('default', $plan->stripe_price_id)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('subscription.cancel'),

                'metadata' => [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                ],
            ]);
    }

    public function success()
    {
        // dd('Success Method Called');
        return redirect()
            ->route('plans')
            ->with(
                'success',
                'Payment completed successfully.'
            );
    }

    public function cancel()
    {
        $user = auth()->user();

        $subscription = $user->subscription('default');

        $pyment = Payment::where('user_id', $user->id)
            ->where('payment_status', 'Paid')
            ->latest()
            ->first();

        // Only cancel if REAL Stripe subscription exists
        if ($subscription && str_starts_with($subscription->stripe_id, 'sub_')) {

            try {

                $subscription->cancelNow();


                $pyment->update([
                    'payment_status' => 'Cancelled',
                ]);
            } catch (\Exception $e) {
                return redirect()
                    ->route('profile.myprofile')
                    ->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
            }
        }

        // Always downgrade user locally
        $user->update([
            'role' => 'Free',
            'plan' => 'free',
        ]);

        return redirect()
            ->route('profile.myprofile')
            ->with('success', 'Subscription cancelled successfully. If you are eligible for a refund, the amount will be credited to your account within 3–4 business days.
');
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
