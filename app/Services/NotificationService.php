<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Mail\AttendanceAbsentMail;
use App\Mail\AttendancePresentMail;
use App\Mail\AttendanceLateMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    /**
     * Send notification for attendance.
     */
    public function sendAttendanceNotification(Attendance $attendance, array $channels = ['email'])
    {
        $student = $attendance->student;
        $status = $attendance->status;
        $date = $attendance->date;
        $className = $attendance->tuitionClass->name ?? 'Class';

        foreach ($channels as $channel) {
            try {
                match ($channel) {
                    'email' => $this->sendEmail($student, $status, $date, $className),
                    'whatsapp' => $this->sendWhatsApp($student, $status, $date, $className, 'attendance'),
                    default => null
                };
            } catch (\Exception $e) {
                Log::error("Notification failed for student {$student->id} via {$channel}: " . $e->getMessage());
            }
        }
    }

    /**
     * Send notification for new assignment.
     */
    public function sendAssignmentNotification(Assignment $assignment, array $channels = ['email'])
    {
        $tuitionClass = $assignment->tuitionClass;
        $students = $tuitionClass->students;

        foreach ($students as $student) {
            foreach ($channels as $channel) {
                try {
                    match ($channel) {
                        'email' => $this->sendAssignmentEmail($student, $assignment),
                        'whatsapp' => $this->sendWhatsApp($student, null, null, null, 'assignment', $assignment),
                        default => null
                    };
                } catch (\Exception $e) {
                    Log::error("Assignment notification failed for student {$student->id} via {$channel}: " . $e->getMessage());
                }
            }
        }
    }

    private function sendEmail(Student $student, $status, $date, $className)
    {
        $emailTo = $student->guardian_email ?: $student->email;
        if (!$emailTo)
            return;

        $mailable = match ($status) {
            'absent' => new AttendanceAbsentMail($student, $date, $className),
            'present' => new AttendancePresentMail($student, $date, $className),
            'late' => new AttendanceLateMail($student, $date, $className),
            default => null
        };

        if ($mailable) {
            Mail::to($emailTo)->send($mailable);
        }
    }

    private function sendAssignmentEmail(Student $student, Assignment $assignment)
    {
        $emailTo = $student->guardian_email ?: $student->email;
        if (!$emailTo)
            return;

        // Note: Assuming there's an AssignmentMail or similar, if not, we use log for now or create one.
        Log::info("Email notification: New assignment '{$assignment->title}' for student {$student->full_name}");
    }

    private function sendWhatsApp(Student $student, $status, $date, $className, $type, $assignment = null)
    {
        $phone = $student->guardian_phone ?: $student->phone;
        if (!$phone)
            return;

        // Ensure phone starts with country code (assuming India +91 if not present)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        if (env('WHATSAPP_DRIVER', 'log') === 'log') {
            $message = $this->getMessageContent($student, $status, $date, $className, $type, $assignment);
            Log::info("WhatsApp Notification (LOG) to {$cleanPhone}: {$message}");
            return;
        }

        if (env('WHATSAPP_DRIVER') === 'meta') {
            $this->sendMetaWhatsApp($cleanPhone, $status, $date, $className, $type, $assignment);
        }
    }

    private function sendMetaWhatsApp($phone, $status, $date, $className, $type, $assignment = null)
    {
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $accessToken = env('WHATSAPP_ACCESS_TOKEN');

        if (!$phoneNumberId || !$accessToken) {
            Log::error("Meta WhatsApp configuration missing.");
            return;
        }

        $templateName = ($type === 'attendance')
            ? env('WHATSAPP_TEMPLATE_ATTENDANCE', 'attendance_alert')
            : env('WHATSAPP_TEMPLATE_ASSIGNMENT', 'new_assignment');

        // Prepare components for template
        $components = [];
        if ($type === 'attendance') {
            $components = [
                [
                    'type' => 'body',
                    'parameters' => [
                        ['type' => 'text', 'text' => $status],
                        ['type' => 'text', 'text' => $className],
                        ['type' => 'text', 'text' => $date],
                    ]
                ]
            ];
        } else {
            $components = [
                [
                    'type' => 'body',
                    'parameters' => [
                        ['type' => 'text', 'text' => $assignment->title],
                        ['type' => 'text', 'text' => $className],
                        ['type' => 'text', 'text' => $assignment->due_date],
                    ]
                ]
            ];
        }

        $response = Http::withToken($accessToken)->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => ['code' => 'en_US'],
                'components' => $components
            ]
        ]);

        if ($response->failed()) {
            Log::error("Meta WhatsApp API Error: " . $response->body());
        } else {
            Log::info("Meta WhatsApp sent to {$phone}");
        }
    }

    private function getMessageContent(Student $student, $status, $date, $className, $type, $assignment = null)
    {
        if ($type === 'attendance') {
            return "Parent Alert: {$student->full_name} was marked {$status} for [{$className}] on {$date}. - BrightMind Academy";
        } elseif ($type === 'assignment') {
            return "New Academic Work: A new assignment '{$assignment->title}' has been published for [{$student->tuitionClass->name}]. Due: {$assignment->due_date}. - BrightMind Academy";
        }
        return '';
    }
}
