<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filter extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'profile_id',
        'age_from',
        'age_to',
        'gender',
        'religion',
        'community',
        'profession',
        'country',
        'state',
        'city',
        'marital_status'
    ];

    // Filter belongs to profile
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
