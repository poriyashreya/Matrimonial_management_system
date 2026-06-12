<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'couple_name',
        'status',
        'message',
        'image',
        'is_active'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}

