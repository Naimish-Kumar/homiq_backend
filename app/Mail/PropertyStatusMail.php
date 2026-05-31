<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropertyStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $ownerName;
    public string $propertyTitle;
    public string $status;

    /**
     * Create a new message instance.
     */
    public function __construct(string $ownerName, string $propertyTitle, string $status)
    {
        $this->ownerName = $ownerName;
        $this->propertyTitle = $propertyTitle;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'HomiQ - Property Listing Status Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.property-status',
        );
    }
}
