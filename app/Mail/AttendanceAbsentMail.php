<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttendanceAbsentMail extends Mailable
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
            subject: "Attendance Alert – {$this->student->full_name} was marked Absent on {$this->date}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.attendance_absent',
        );
    }
}
