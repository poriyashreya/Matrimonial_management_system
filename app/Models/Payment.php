<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',

        'stripe_payment_id',
        'stripe_payment_intent',
        'stripe_invoice_id',
        'stripe_charge_id',

        'amount',
        'refund_amount',

        'currency',

        'payment_status',
        'failure_reason',

        'paid_at',
        'refunded_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}