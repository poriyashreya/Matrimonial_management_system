<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $table = 'user_request';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'is_pending',
        'is_accepted',
        'is_rejected',
        'is_canceled',
        'is_blocked',
    ];

    // Sender profile
    public function sender()
    {
        return $this->belongsTo(Profile::class, 'sender_id');
    }

    // Receiver profile
    public function receiver()
    {
        return $this->belongsTo(Profile::class, 'receiver_id');
    }
}
