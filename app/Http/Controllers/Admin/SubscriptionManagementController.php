<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionManagementController extends Controller
{
    public function index()
    {
        $subscriptions = Payment::with(['user', 'plan'])
            ->orderBy('payment_status', 'desc')
            ->paginate(7);

        // Add purchase_date & expiry_date
        $subscriptions->getCollection()->transform(function ($subscription) {

            $purchaseDate = Carbon::parse($subscription->paid_at);

            $subscription->purchase_date =
                $purchaseDate->format('d M Y');

            $subscription->expiry_date =
                $purchaseDate->copy()
                    ->addMonth()
                    ->format('d M Y');

            return $subscription;
        });

        // Total Revenue
        $totalRevenue = Payment::where('payment_status', 'Paid')
            ->sum('amount');

        // Premium Users
        $premiumUsers = DB::table('users')
            ->where('role', 'Premium')
            ->count();

        // Pro Users
        $proUsers = DB::table('users')
            ->where('role', 'Pro')
            ->count();

        return view(
            'admin.subscriptions.index',
            compact(
                'subscriptions',
                'totalRevenue',
                'premiumUsers',
                'proUsers'
            )
        );
    }

    /*  Cancel Subscription*/
    public function cancel($id)
    {
        $payment = Payment::findOrFail($id);

        // Update payment status
        $payment->update([
            'payment_status' => 'Cancelled'
        ]);

        // Downgrade user to free
        User::where('id', $payment->user_id)
            ->update([
                'role' => 'free'
            ]);

        return back()->with(
            'success',
            'Subscription cancelled successfully.'
        );
    }
}