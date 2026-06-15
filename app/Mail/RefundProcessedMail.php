<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundProcessedMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $refundAmount;

    public function __construct($user, $refundAmount)
    {
        $this->user = $user;
        $this->refundAmount = $refundAmount;
    }

    public function build()
    {
        return $this->subject('Subscription Refund Processed')
            ->view('emails.refund-processed');
    }
}