<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'doc_type',
        'doc_path',
        'status'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
