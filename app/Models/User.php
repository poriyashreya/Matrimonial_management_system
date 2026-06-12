<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

use App\Models\Profile;
use App\Models\Rating;
use App\Models\Payment;

class User extends Authenticatable
{
    use Billable, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'gender',
        'password',
        'role',
        'plan',
    ];

    /**
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ROLE METHODS    */

    public function isAdmin()
    {
        return strtolower($this->role) === 'admin';
    }

    public function isUser()
    {
        return strtolower($this->role) === 'user';
    }

    /*  SUBSCRIPTION METHODS */
    public function isFree()
    {
        return !$this->subscribed('default');
    }

    public function isPremium()
    {
        return $this->subscribed('default') &&
            optional($this->subscription('default'))->stripe_price === config('plans.premium');
    }

    public function isPro()
    {
        return $this->subscribed('default') &&
            optional($this->subscription('default'))->stripe_price === config('plans.pro');
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('stripe_status', 'active')
            ->latest()
            ->first();
    }

    /* RELATIONSHIPS */

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /* DELETE NOTIFICATIONS */

    protected static function booted()
    {
        static::deleting(function ($user) {

            \DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('notifiable_type', get_class($user))
                ->delete();
        });
    }
}