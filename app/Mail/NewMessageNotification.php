<?php

namespace App\Mail;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public $sender;

    public $receiver;

    public $conversation;

    public function __construct(Message $message, User $sender, User $receiver, Conversation $conversation)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->conversation = $conversation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💬 New Message from '.$this->sender->name.' - Campus Trade',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-message',
        );
    }
}
