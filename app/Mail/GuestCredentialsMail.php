<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GuestCredentialsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $tempPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Akun Anda Telah Dibuat — JAFAPP Furniture',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.guest-credentials',
            with: [
                'user' => $this->user,
                'tempPassword' => $this->tempPassword,
                'activationUrl' => route('activation.set-password', $this->user->activation_token),
            ],
        );
    }
}
