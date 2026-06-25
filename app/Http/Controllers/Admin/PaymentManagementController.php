<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'plan']);

        /*
        |--------------------------------------------------------------------------
        | Search by User Name / Email
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('user', function ($userQuery) use ($search) {

                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });

                $q->orWhere('stripe_payment_id', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            $query->where(
                'payment_status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Date
        |--------------------------------------------------------------------------
        */
        if ($request->filled('payment_date')) {

            $query->whereDate(
                'paid_at',
                $request->payment_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        switch ($request->sort_by) {

            case 'amount_asc':
                $query->orderBy('amount', 'asc');
                break;

            case 'amount_desc':
                $query->orderBy('amount', 'desc');
                break;

            case 'status_asc':
                $query->orderBy('payment_status', 'asc');
                break;

            case 'status_desc':
                $query->orderBy('payment_status', 'desc');
                break;

            case 'oldest':
                $query->oldest();
                break;

            default:
                $query->latest();
        }

        $payments = $query
            ->paginate(6)
            ->withQueryString();

        $totalRevenue = Payment::where(
            'payment_status',
            'Paid'
        )->sum('amount');

        return view(
            'admin.payments.index',
            compact(
                'payments',
                'totalRevenue'
            )
        );
    }
}
