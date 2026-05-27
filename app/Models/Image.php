<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
        'file_name',
        'file_path',
        'Type_of_image',
    ];

    // Image belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Image belongs to a profile
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
