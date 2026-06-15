<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionActivatedMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $payment;

    public function __construct($user, $payment)
    {
        $this->user = $user;
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject('Subscription Activated Successfully')
            ->view('emails.subscription-activated');
    }
}