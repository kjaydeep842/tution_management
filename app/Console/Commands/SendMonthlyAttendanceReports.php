<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\Attendance;
use App\Mail\AttendanceReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SendMonthlyAttendanceReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:send-monthly {--student= : Send only for a specific student ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and email monthly attendance reports to parents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastMonth = Carbon::now()->subMonth();
        $month = $lastMonth->month;
        $year = $lastMonth->year;
        $monthName = $lastMonth->format('F');

        $query = Student::with(['tuitionClass']);

        if ($this->option('student')) {
            $query->where('id', $this->option('student'));
        }

        $students = $query->get();

        $this->info("Starting attendance report generation for {$monthName} {$year}...");
        $bar = $this->output->createProgressBar(count($students));
        $bar->start();

        foreach ($students as $student) {
            // Get attendance for the month
            $startOfMonth = $lastMonth->copy()->startOfMonth();
            $endOfMonth = $lastMonth->copy()->endOfMonth();

            $attendances = Attendance::where('student_id', $student->id)
                ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get()
                ->keyBy('date');

            // Generate full month dates
            $allDates = [];
            $cursor = $startOfMonth->copy();
            while ($cursor->lte($endOfMonth)) {
                $allDates[$cursor->toDateString()] = $attendances->get($cursor->toDateString());
                $cursor->addDay();
            }

            // Stats
            $total = count($allDates);
            $present = $attendances->where('status', 'present')->count();
            $absent = $attendances->where('status', 'absent')->count();
            $pct = $total > 0 ? round(($present / $total) * 100) : 0;

            $data = [
                'student' => $student,
                'attendances' => $allDates,
                'monthName' => $monthName,
                'year' => $year,
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'pct' => $pct
            ];

            // Generate PDF
            $pdfContent = Pdf::loadView('pdf.attendance_pdf', $data)->output();

            // Determine recipient email
            $email = $student->guardian_email;

            // If linked to a user account, use that email too or instead? 
            // Usually guardian_email is the primary contact.

            // Send WhatsApp notification
            try {
                $notificationService = new \App\Services\NotificationService();
                $notificationService->sendMonthlyReportNotification($student, $data);
            } catch (\Exception $e) {
                $this->error("\nFailed to send WhatsApp to student #{$student->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info("\nDone! Attendance reports sent.");
    }
}
