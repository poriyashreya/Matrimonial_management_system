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
        'amount_refunded',

        'currency',
        'credit',

        'payment_status',
        'failure_reason',

        'paid_at',
        'refund_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'refund_at' => 'datetime',

        'amount' => 'float',
        'credit' => 'float',
        'amount_refunded' => 'float',
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