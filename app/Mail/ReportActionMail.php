<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $profileId;
    public $userName;

    public function __construct($messageContent, $profileId, $userName)
    {
        $this->messageContent = $messageContent;
        $this->profileId = $profileId;
        $this->userName = $userName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Report Action Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.report.action',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
