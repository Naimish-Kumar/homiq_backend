<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $userName;
    public string $propertyTitle;
    public string $status;
    public string $checkIn;
    public string $checkOut;
    public string $totalPrice;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $userName,
        string $propertyTitle,
        string $status,
        string $checkIn,
        string $checkOut,
        string $totalPrice
    ) {
        $this->userName = $userName;
        $this->propertyTitle = $propertyTitle;
        $this->status = $status;
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;
        $this->totalPrice = $totalPrice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'HomiQ - Booking Status Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-status',
        );
    }
}
