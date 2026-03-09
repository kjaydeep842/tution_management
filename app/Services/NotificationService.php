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
    public function sendAttendanceNotification(Attendance $attendance, array $channels = ['whatsapp'])
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
    public function sendAssignmentNotification(Assignment $assignment, array $channels = ['whatsapp'])
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

    /**
     * Send notification for parent account creation.
     */
    public function sendAccountCreationNotification(Student $student, string $phone, string $password, array $channels = ['whatsapp'])
    {
        foreach ($channels as $channel) {
            try {
                match ($channel) {
                    'whatsapp' => $this->sendWhatsApp($student, null, null, null, 'account_created', null, ['phone' => $phone, 'password' => $password]),
                    default => null
                };
            } catch (\Exception $e) {
                Log::error("Account creation notification failed for student {$student->id} via {$channel}: " . $e->getMessage());
            }
        }
    }

    /**
     * Send notification for performance report.
     */
    public function sendPerformanceReportNotification($report, array $channels = ['whatsapp'])
    {
        $student = $report->student;
        foreach ($channels as $channel) {
            try {
                match ($channel) {
                    'whatsapp' => $this->sendWhatsApp($student, null, null, null, 'performance_report', null, ['report' => $report]),
                    default => null
                };
            } catch (\Exception $e) {
                Log::error("Performance report notification failed for student {$student->id} via {$channel}: " . $e->getMessage());
            }
        }
    }

    /**
     * Send notification for monthly attendance report.
     */
    public function sendMonthlyReportNotification(Student $student, array $data, array $channels = ['whatsapp'])
    {
        foreach ($channels as $channel) {
            try {
                match ($channel) {
                    'whatsapp' => $this->sendWhatsApp($student, null, null, null, 'monthly_report', null, $data),
                    default => null
                };
            } catch (\Exception $e) {
                Log::error("Monthly report notification failed for student {$student->id} via {$channel}: " . $e->getMessage());
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

    private function sendWhatsApp(Student $student, $status, $date, $className, $type, $assignment = null, $extraData = [])
    {
        $phone = $student->guardian_phone ?: ($student->user ? $student->user->phone : $student->phone);
        if (!$phone)
            return;

        // Ensure phone starts with country code (assuming India +91 if not present)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $message = $this->getMessageContent($student, $status, $date, $className, $type, $assignment, $extraData);

        if (env('WHATSAPP_DRIVER', 'log') === 'log') {
            Log::info("WhatsApp Notification (LOG) to {$cleanPhone}: {$message}");
            return;
        }

        if (env('WHATSAPP_DRIVER') === 'meta') {
            $this->sendMetaWhatsApp($cleanPhone, $message, $type);
        }
    }

    private function sendMetaWhatsApp($phone, $message, $type)
    {
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $accessToken = env('WHATSAPP_ACCESS_TOKEN');

        if (!$phoneNumberId || !$accessToken) {
            Log::error("Meta WhatsApp configuration missing.");
            return;
        }

        // For now using simple text message instead of templates to be more flexible
        $response = Http::withToken($accessToken)->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $phone,
            'type' => 'text',
            'text' => ['body' => $message],
        ]);

        if ($response->failed()) {
            Log::error("Meta WhatsApp API Error: " . $response->body());
        } else {
            Log::info("Meta WhatsApp sent to {$phone}");
        }
    }

    private function getMessageContent(Student $student, $status, $date, $className, $type, $assignment = null, $extraData = [])
    {
        $companyName = "Commerce Expert";

        if ($type === 'attendance') {
            return "Parent Alert: {$student->full_name} was marked {$status} for [{$className}] on {$date}. - {$companyName}";
        } elseif ($type === 'assignment') {
            return "New Academic Work: A new assignment '{$assignment->title}' has been published for [{$student->tuitionClass->name}]. Due: {$assignment->due_date}. - {$companyName}";
        } elseif ($type === 'account_created') {
            return "Welcome to {$companyName}! 🎓\n\nParent Portal Access created for {$student->full_name}.\n\nLogin ID: {$extraData['phone']}\nPassword: {$extraData['password']}\nPortal: " . route('parent.login') . "\n\nKeep these details safe.";
        } elseif ($type === 'performance_report') {
            $report = $extraData['report'];
            return "Academic Progress Update! 📈\n\nStudent: {$student->full_name}\nOverall Performance: {$report->overall_performance}\n\nPlease check the detailed report here: " . route('performance-reports.download', $report) . "\n\n- {$companyName}";
        } elseif ($type === 'monthly_report') {
            return "Monthly Attendance Summary: {$extraData['monthName']} {$extraData['year']} 📊\n\nStudent: {$student->full_name}\nTotal Days: {$extraData['total']}\nPresent: {$extraData['present']}\nAttendance: {$extraData['pct']}%\n\nKeep up the great work! - {$companyName}";
        }
        return '';
    }
}
