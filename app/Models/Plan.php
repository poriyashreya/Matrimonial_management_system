<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'stripe_price_id',
        'duration',
        'features',
        'status'
    ];
}