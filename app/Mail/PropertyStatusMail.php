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
    public ?string $reason;
    public ?string $notes;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $ownerName,
        string $propertyTitle,
        string $status,
        ?string $reason = null,
        ?string $notes = null
    ) {
        $this->ownerName = $ownerName;
        $this->propertyTitle = $propertyTitle;
        $this->status = $status;
        $this->reason = $reason;
        $this->notes = $notes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = ucfirst($this->status);
        return new Envelope(
            subject: "HomiQ - Property Listing {$statusText}: {$this->propertyTitle}",
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
