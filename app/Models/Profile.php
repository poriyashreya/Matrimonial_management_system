<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'religion',
        'community',
        'marital_status',
        'education',
        'profession',
        'preferences',
        'country',
        'state',
        'city',
        'visibility',
        'is_active',
        'verified_by',
    ];

    protected $casts = [
        'verified_by' => 'boolean',
        'preferences' => 'array',
    ];

    /*--------------------------------------------------------------
     |  RELATIONSHIPS
     --------------------------------------------------------------*/

    // A profile belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A profile can have many images
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // One filter only
    public function filters()
    {
        // return $this->hasOne(Filter::class);
        return $this->hasOne(Filter::class, 'profile_id', 'id');
    }

    // Requests User Has Sent
    public function sentRequests()
    {
        return $this->hasMany(UserRequest::class, 'sender_id');
    }

    // Requests User Has Received
    public function receivedRequests()
    {
        return $this->hasMany(UserRequest::class, 'receiver_id');
    }

    // Verification documents
    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    /*--------------------------------------------------------------
     |  ACCESSORS
     --------------------------------------------------------------*/

    public function getMainImageAttribute()
    {
        return $this->images()->first()?->file_path ?? 'https://via.placeholder.com/400';
    }

    public function getFullLocationAttribute()
    {
        return "{$this->city}, {$this->state}, {$this->country}";
    }
}
