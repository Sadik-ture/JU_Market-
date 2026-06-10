<?php

namespace App\Mail;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ItemSoldNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $listing;

    public $seller;

    public $buyer;

    public function __construct(Listing $listing, User $seller, User $buyer)
    {
        $this->listing = $listing;
        $this->seller = $seller;
        $this->buyer = $buyer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Your Item Has Been Sold! - Campus Trade',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.item-sold',
        );
    }
}
