<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileReports extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reported_profile_id',
        'reason',
        'description',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedProfile()
    {
        return $this->belongsTo(Profile::class, 'reported_profile_id');
    }
}
