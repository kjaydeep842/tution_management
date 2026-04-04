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
        $student   = $attendance->student;
        $status    = $attendance->status;
        $date      = $attendance->date;
        $className = $attendance->tuitionClass->name ?? 'Class';

        foreach ($channels as $channel) {
            try {
                match ($channel) {
                    'email'    => $this->sendEmail($student, $status, $date, $className),
                    'whatsapp' => $this->sendWhatsApp($student, $status, $date, $className, 'attendance'),
                    default    => null
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
        $students     = $tuitionClass->students;

        foreach ($students as $student) {
            foreach ($channels as $channel) {
                try {
                    match ($channel) {
                        'email'    => $this->sendAssignmentEmail($student, $assignment),
                        'whatsapp' => $this->sendWhatsApp($student, null, null, null, 'assignment', $assignment),
                        default    => null
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
                    default    => null
                };
            } catch (\Exception $e) {
                Log::error("Account creation notification failed for student {$student->id} via {$channel}: " . $e->getMessage());
            }
        }
    }

    /**
     * Send notification for performance report.
     */
    public function sendPerformanceReportNotification($report, array $channels = ['whatsapp'], $pdfPath = null)
    {
        $student = $report->student;
        foreach ($channels as $channel) {
            try {
                match ($channel) {
                    'whatsapp' => $this->sendWhatsApp($student, null, null, null, 'performance_report', null, ['report' => $report], $pdfPath),
                    default    => null
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
                    default    => null
                };
            } catch (\Exception $e) {
                Log::error("Monthly report notification failed for student {$student->id} via {$channel}: " . $e->getMessage());
            }
        }
    }

    // -------------------------------------------------------------------------
    // Email helpers
    // -------------------------------------------------------------------------

    private function sendEmail(Student $student, $status, $date, $className)
    {
        $emailTo = $student->guardian_email ?: $student->email;
        if (!$emailTo) {
            return;
        }

        $mailable = match ($status) {
            'absent'  => new AttendanceAbsentMail($student, $date, $className),
            'present' => new AttendancePresentMail($student, $date, $className),
            'late'    => new AttendanceLateMail($student, $date, $className),
            default   => null
        };

        if ($mailable) {
            Mail::to($emailTo)->send($mailable);
        }
    }

    private function sendAssignmentEmail(Student $student, Assignment $assignment)
    {
        $emailTo = $student->guardian_email ?: $student->email;
        if (!$emailTo) {
            return;
        }

        Log::info("Email notification: New assignment '{$assignment->title}' for student {$student->full_name}");
    }

    // -------------------------------------------------------------------------
    // WhatsApp helpers
    // -------------------------------------------------------------------------

    private function sendWhatsApp(Student $student, $status, $date, $className, $type, $assignment = null, $extraData = [], $pdfPath = null)
    {
        $phone = $student->guardian_phone ?: ($student->user ? $student->user->phone : $student->phone);
        if (!$phone) {
            return;
        }

        // Normalise to E.164 (India +91 if plain 10-digit)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $message = $this->getMessageContent($student, $status, $date, $className, $type, $assignment, $extraData);
        $rawData = compact('student', 'status', 'date', 'className', 'assignment', 'extraData', 'pdfPath');

        if (env('WHATSAPP_DRIVER', 'log') === 'log') {
            Log::info("WhatsApp Notification (LOG) to {$cleanPhone}: {$message}");
            return;
        }

        if (env('WHATSAPP_DRIVER') === 'meta') {
            $this->sendMetaWhatsApp($cleanPhone, $message, $type, $rawData);
        }
    }

    private function sendMetaWhatsApp($phone, $message, $type, $rawData = [])
    {
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $accessToken   = env('WHATSAPP_ACCESS_TOKEN');

        if (!$phoneNumberId || !$accessToken) {
            Log::error('Meta WhatsApp configuration missing.');
            return;
        }

        if ($type === 'attendance') {
            $this->sendAttendanceTemplate($phone, $rawData);
            return;
        }

        if ($type === 'performance_report') {
            $this->sendMarksTemplate($phone, $rawData);
            return;
        }

        // Plain text fallback for other types
        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type'    => 'individual',
            'to'                => $phone,
            'type'              => 'text',
            'text'              => ['body' => $message],
        ];

        Log::debug('WhatsApp API Request [text]', [
            'url'     => "https://graph.facebook.com/v21.0/{$phoneNumberId}/messages",
            'payload' => $payload,
        ]);

        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/messages", $payload);

        Log::debug('WhatsApp API Response [text]', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        if ($response->failed()) {
            Log::error('Meta WhatsApp API Error: ' . $response->body());
        } else {
            Log::info("Meta WhatsApp sent to {$phone}");
        }
    }

    /**
     * Attendance template in Meta:
     *   Name: attendance_alert
     *   Category: UTILITY | Language: English (en_US)
     *   Body: Dear Parent, *{{1}}* was marked *{{2}}* on {{3}} for class *{{4}}*. - Commerce Expert
     *
     *   Variables: {{1}} student name, {{2}} status, {{3}} date, {{4}} class name
     */
    private function sendAttendanceTemplate($phone, $rawData)
    {
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $accessToken   = env('WHATSAPP_ACCESS_TOKEN');
        $templateName  = env('WHATSAPP_ATTENDANCE_TEMPLATE', 'hello_world');
        $templateLang  = env('WHATSAPP_ATTENDANCE_TEMPLATE_LANG', 'en_US');

        $student   = $rawData['student'] ?? null;
        $status    = $rawData['status'] ?? 'Unknown';
        $date      = $rawData['date'] ?? now()->format('d-m-Y');
        $className = $rawData['className'] ?? 'Class';

        $components = [];
        if ($templateName !== 'hello_world' && $student) {
            $components = [[
                'type'       => 'body',
                'parameters' => [
                    ['type' => 'text', 'text' => $student->full_name],
                    ['type' => 'text', 'text' => ucfirst($status)],
                    ['type' => 'text', 'text' => $date],
                    ['type' => 'text', 'text' => $className],
                ],
            ]];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to'                => $phone,
            'type'              => 'template',
            'template'          => [
                'name'       => $templateName,
                'language'   => ['code' => $templateLang],
                'components' => $components,
            ],
        ];

        Log::debug('WhatsApp API Request [attendance_template]', [
            'url'     => "https://graph.facebook.com/v21.0/{$phoneNumberId}/messages",
            'payload' => $payload,
        ]);

        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/messages", $payload);

        Log::debug('WhatsApp API Response [attendance_template]', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        if ($response->failed()) {
            Log::error('Attendance template send failed: ' . $response->body());
        } else {
            Log::info("Attendance template sent to {$phone}");
        }
    }

    /**
     * Marks/performance template in Meta:
     *   Name: marks_update
     *   Category: UTILITY | Language: English (en_US)
     *   Body: Dear Parent, here is the latest academic update for *{{1}}*.
     *         Subject: *{{2}}*  |  Marks Obtained: *{{3}}* / {{4}}
     *         Overall Performance: {{5}}. - Commerce Expert
     *
     *   Variables: {{1}} student name, {{2}} subject, {{3}} marks obtained,
     *              {{4}} total marks, {{5}} overall performance
     */
    private function sendMarksTemplate($phone, $rawData)
    {
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $accessToken   = env('WHATSAPP_ACCESS_TOKEN');
        $templateName  = env('WHATSAPP_MARKS_TEMPLATE', 'hello_world');
        $templateLang  = env('WHATSAPP_MARKS_TEMPLATE_LANG', 'en_US');

        $student = $rawData['student'] ?? null;
        $report  = $rawData['extraData']['report'] ?? null;
        $pdfPath = $rawData['pdfPath'] ?? null;

        $components = [];
        if ($templateName !== 'hello_world' && $student && $report) {
            $components = [[
                'type'       => 'body',
                'parameters' => [
                    ['type' => 'text', 'text' => $student->full_name],
                    ['type' => 'text', 'text' => $report->overall_performance ?? 'Not Rated'],
                    ['type' => 'text', 'text' => \Carbon\Carbon::parse($report->report_date)->format('d-M-Y')],
                    ['type' => 'text', 'text' => $report->suggestions ?: 'Please check the portal for full details.'],
                ],
            ]];

            if ($pdfPath && file_exists($pdfPath)) {
                $mediaId = $this->uploadMediaToWhatsApp($pdfPath);
                if ($mediaId) {
                    array_unshift($components, [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'document',
                                'document' => [
                                    'id' => $mediaId,
                                    'filename' => 'Performance_Report_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $student->first_name) . '.pdf'
                                ]
                            ]
                        ]
                    ]);
                }
            }
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to'                => $phone,
            'type'              => 'template',
            'template'          => [
                'name'       => $templateName,
                'language'   => ['code' => $templateLang],
                'components' => $components,
            ],
        ];

        Log::debug('WhatsApp API Request [marks_template]', [
            'url'     => "https://graph.facebook.com/v21.0/{$phoneNumberId}/messages",
            'payload' => $payload,
        ]);

        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/messages", $payload);

        Log::debug('WhatsApp API Response [marks_template]', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        if ($response->failed()) {
            Log::error('Marks template send failed: ' . $response->body());
        } else {
            Log::info("Marks template sent to {$phone}");
        }
    }

    // -------------------------------------------------------------------------
    // Message content builder (used as plain-text fallback / log output)
    // -------------------------------------------------------------------------

    private function getMessageContent(Student $student, $status, $date, $className, $type, $assignment = null, $extraData = [])
    {
        $companyName = "Commerce Expert";

        if ($type === 'attendance') {
            return "Parent Alert: {$student->full_name} was marked {$status} for [{$className}] on {$date}. - {$companyName}";
        } elseif ($type === 'assignment') {
            return "New Academic Work: A new assignment '{$assignment->title}' has been published for [{$student->tuitionClass->name}]. Due: {$assignment->due_date}. - {$companyName}";
        } elseif ($type === 'account_created') {
            return "Welcome to {$companyName}! Parent Portal Access created for {$student->full_name}.\n\nLogin ID: {$extraData['phone']}\nPassword: {$extraData['password']}\nPortal: " . route('login') . "\n\nKeep these details safe.";
        } elseif ($type === 'performance_report') {
            $report = $extraData['report'];
            return "Academic Progress Update! Student: {$student->full_name}\nOverall Performance: {$report->overall_performance}\n\nReport: " . route('performance-reports.download', $report) . "\n\n- {$companyName}";
        } elseif ($type === 'monthly_report') {
            return "Monthly Attendance Summary: {$extraData['monthName']} {$extraData['year']}\n\nStudent: {$student->full_name}\nTotal Days: {$extraData['total']}\nPresent: {$extraData['present']}\nAttendance: {$extraData['pct']}%\n\n- {$companyName}";
        }

        return '';
    }

    /**
     * Upload a local file to Meta WhatsApp Media API and return the media ID
     */
    public function uploadMediaToWhatsApp($filePath, $mimeType = 'application/pdf')
    {
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $accessToken   = env('WHATSAPP_ACCESS_TOKEN');

        if (!file_exists($filePath)) {
            Log::error("WhatsApp Media Upload Failed: File not found at {$filePath}");
            return null;
        }

        $response = Http::withToken($accessToken)
            ->attach('file', file_get_contents($filePath), basename($filePath), ['Content-Type' => $mimeType])
            ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/media", [
                'messaging_product' => 'whatsapp'
            ]);

        if ($response->successful()) {
            return $response->json('id');
        }

        Log::error("WhatsApp Media Upload API Failed: " . $response->body());
        return null;
    }

    /**
     * Send Monthly Attendance PDF Template using Meta Cloud API
     */
    public function sendMonthlyReportNotificationPdf(Student $student, $data, $pdfPath)
    {
        $phone = $student->guardian_phone;
        if (!$phone) return;

        // Ensure proper international formatting
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) == 10) {
            $phone = '91' . $phone; // Default to India code if 10 digits
        }

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $accessToken   = env('WHATSAPP_ACCESS_TOKEN');
        $templateName  = env('WHATSAPP_MONTHLY_PDF_TEMPLATE', 'monthly_attendance_pdf');
        $templateLang  = env('WHATSAPP_MONTHLY_PDF_TEMPLATE_LANG', 'en');

        // 1. Upload the PDF to get the Media ID
        $mediaId = $this->uploadMediaToWhatsApp($pdfPath);

        if (!$mediaId) {
            Log::error("Failed to send Monthly PDF to {$phone} - Media Upload step failed.");
            return;
        }

        // 2. Map variables for body
        // {{1}} = Student Name
        // {{2}} = Month Name Year
        // {{3}} = Total Days
        // {{4}} = Present Days
        // {{5}} = Attendance %
        $bodyParams = [
            ['type' => 'text', 'text' => $student->full_name],
            ['type' => 'text', 'text' => $data['monthName'] . ' ' . $data['year']],
            ['type' => 'text', 'text' => (string)$data['total']],
            ['type' => 'text', 'text' => (string)$data['present']],
            ['type' => 'text', 'text' => (string)$data['pct']]
        ];

        // 3. Build Components with Document Header
        $components = [
            [
                'type' => 'header',
                'parameters' => [
                    [
                        'type' => 'document',
                        'document' => [
                            'id' => $mediaId,
                            'filename' => "Attendance_{$data['monthName']}.pdf"
                        ]
                    ]
                ]
            ],
            [
                'type' => 'body',
                'parameters' => $bodyParams
            ]
        ];

        $payload = [
            'messaging_product' => 'whatsapp',
            'to'                => $phone,
            'type'              => 'template',
            'template'          => [
                'name'       => $templateName,
                'language'   => ['code' => $templateLang],
                'components' => $components,
            ],
        ];

        Log::debug('WhatsApp API Request [monthly_attendance_pdf]', [
            'url'     => "https://graph.facebook.com/v21.0/{$phoneNumberId}/messages",
            'payload' => $payload,
        ]);

        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/messages", $payload);

        Log::debug('WhatsApp API Response [monthly_attendance_pdf]', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        if ($response->failed()) {
            Log::error("Monthly PDF template send failed for {$phone}: " . $response->body());
        } else {
            Log::info("Monthly PDF template sent to {$phone}");
        }
    }
}
