<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentManagementController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'plan')
            ->latest()
            ->paginate(6);

        $totalRevenue = Payment::sum('amount');

        return view('admin.payments.index', compact(
            'payments',
            'totalRevenue'
        ));
    }
}
