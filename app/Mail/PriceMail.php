<?php

namespace App\Mail;

use App\Models\Cryptocurrency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class PriceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Cryptocurrency $crypto;
    public string $priceChange;

    /**
     * Create a new message instance.
     */
    public function __construct($crypto, $priceChange)
    {
        $this->crypto = $crypto;
        $this->priceChange = $priceChange;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), 'Price Alert Mail'),
            subject: 'Price Alert Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.default_template',
            with: [
                'crypto' => $this->crypto,
                'priceChange' => $this->priceChange
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
