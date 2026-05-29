<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\CustomOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomOrderApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public CustomOrder $customOrder) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Custom Order Anda Disetujui — JAFAPP Furniture',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.custom-order-approved',
        );
    }
}
