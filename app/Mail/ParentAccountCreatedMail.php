<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ParentAccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $guardianName,
        public string $studentName,
        public string $phone,
        public string $password,
        public string $portalUrl
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Parent Portal Access – {$this->studentName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.parent_account_created',
        );
    }
}
