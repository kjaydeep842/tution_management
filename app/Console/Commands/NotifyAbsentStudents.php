<?php

namespace App\Console\Commands;

use App\Mail\AttendanceAbsentMail;
use App\Models\Attendance;
use App\Models\TuitionClass;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyAbsentStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:notify-absent
                            {--force : Run even on weekends (for testing)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send absence email to parents 30 minutes after class starts on working days (Mon–Fri).';

    public function handle(): int
    {
        $now = Carbon::now();

        // Skip weekends unless --force is passed
        if (!$this->option('force') && $now->isWeekend()) {
            $this->info("Today is {$now->format('l')} — skipping (not a working day).");
            return self::SUCCESS;
        }

        $today = $now->toDateString();
        $this->info("Checking absent students for {$today} at {$now->format('H:i')} …");

        // Load all classes that have a class_time set
        $classes = TuitionClass::whereNotNull('class_time')->get();

        if ($classes->isEmpty()) {
            $this->warn('No classes have a class_time set. Please configure class times in Admin → Classes.');
            return self::SUCCESS;
        }

        $emailsSent = 0;

        foreach ($classes as $tuitionClass) {
            // Parse the stored class_time
            $classStartTime = Carbon::createFromTimeString($tuitionClass->class_time);
            $notifyAfter = $classStartTime->copy()->addMinutes(30);

            // We only process this class if the current time is AFTER (class_time + 30 min)
            if ($now->lt($notifyAfter)) {
                $this->line("   ⏳ Class [{$tuitionClass->name}] — too early. Scheduled for {$notifyAfter->format('H:i')}.");
                continue;
            }

            $this->line("⏰  Class [{$tuitionClass->name}] — processing pending absent notifications.");

            // Find all attendance records marked 'absent' for this class today that haven't been notified
            $absentRecords = Attendance::with('student')
                ->where('tuition_class_id', $tuitionClass->id)
                ->where('date', $today)
                ->where('status', 'absent')
                ->whereNull('notified_at')
                ->get();

            if ($absentRecords->isEmpty()) {
                $this->line("   ✅ All absent students for [{$tuitionClass->name}] have already been notified.");
                continue;
            }

            foreach ($absentRecords as $record) {
                $student = $record->student;
                if (!$student)
                    continue;

                $emailTo = $student->guardian_email ?: $student->email;

                if (!$emailTo) {
                    $this->warn("   ⚠️  No email for student Roll #{$student->roll_no} ({$student->full_name}) — skipping.");
                    continue;
                }

                try {
                    $notificationService = new NotificationService();
                    $notificationService->sendAttendanceNotification($record, ['email', 'whatsapp']);

                    $emailsSent++;
                    $this->line("   📢 Notifications sent → Roll #{$student->roll_no} – {$student->full_name}");
                    Log::info("AbsentNotify (Scheduled): Sent to student {$student->id} ({$student->full_name}), class {$tuitionClass->name}, date {$today}.");

                } catch (\Exception $e) {
                    $this->error("   ❌ Failed to queue email to {$emailTo}: " . $e->getMessage());
                    Log::error("AbsentNotify (Command): Failed for student {$student->id} – " . $e->getMessage());
                }
            }
        }

        $this->info("Done. Total emails queued: {$emailsSent}");
        return self::SUCCESS;
    }
}
