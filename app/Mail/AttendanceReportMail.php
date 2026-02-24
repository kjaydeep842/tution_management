<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttendanceReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $attendances;
    public $monthName;
    public $year;
    public $total;
    public $present;
    public $pct;
    protected $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $pdfContent)
    {
        $this->student = $data['student'];
        $this->attendances = $data['attendances'];
        $this->monthName = $data['monthName'];
        $this->year = $data['year'];
        $this->total = $data['total'];
        $this->present = $data['present'];
        $this->pct = $data['pct'];
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->monthName . ' Attendance Report - ' . $this->student->full_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.attendance_report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $filename = 'Attendance_Report_' . str_replace(' ', '_', $this->student->full_name) . '_' . $this->monthName . '.pdf';

        return [
            Attachment::fromData(fn() => $this->pdfContent, $filename)
                ->withMime('application/pdf'),
        ];
    }
}
