<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IDVerificationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $status;

    public $reason;

    public function __construct(User $user, $status, $reason = null)
    {
        $this->user = $user;
        $this->status = $status;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        if ($this->status == 'approved') {
            $subject = '✅ Your Student ID Has Been Verified! - Campus Trade';
        } else {
            $subject = '❌ Student ID Verification Update - Campus Trade';
        }

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.id-verification',
        );
    }
}
