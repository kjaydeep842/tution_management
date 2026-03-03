<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttendanceLateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Student $student,
        public string $date,
        public string $className
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Attendance Update – {$this->student->full_name} was marked Late on {$this->date}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.attendance_late',
        );
    }
}
