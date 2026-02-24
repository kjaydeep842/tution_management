<?php

namespace App\Console\Commands;

use App\Mail\AttendanceAbsentMail;
use App\Models\Attendance;
use App\Models\TuitionClass;
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
            // Parse the stored class_time and add 30 minutes
            $notifyAt = Carbon::createFromTimeString($tuitionClass->class_time)->addMinutes(30);

            // Only act if we are within the same minute window
            // (scheduler runs every minute; we check HH:MM match)
            if ($now->format('H:i') !== $notifyAt->format('H:i')) {
                continue;
            }

            $this->line("⏰  Class [{$tuitionClass->name}] — notify window matched ({$notifyAt->format('H:i')}).");

            // Find all attendance records marked 'absent' for this class today
            $absentRecords = Attendance::with('student')
                ->where('tuition_class_id', $tuitionClass->id)
                ->where('date', $today)
                ->where('status', 'absent')
                ->get();

            if ($absentRecords->isEmpty()) {
                $this->line("   ✅ No absent students found for [{$tuitionClass->name}] today.");
                continue;
            }

            foreach ($absentRecords as $record) {
                $student = $record->student;

                if (!$student) {
                    continue;
                }

                // Use guardian_email first, fall back to student's own email
                $emailTo = $student->guardian_email ?: $student->email;

                if (!$emailTo) {
                    $this->warn("   ⚠️  No email for student Roll #{$student->roll_no} ({$student->full_name}) — skipping.");
                    continue;
                }

                try {
                    Mail::to($emailTo)->send(new AttendanceAbsentMail(
                        $student,
                        $today,
                        $tuitionClass->name
                    ));

                    $emailsSent++;
                    $this->line("   📧 Email sent → Roll #{$student->roll_no} – {$student->full_name} → {$emailTo}");
                    Log::info("AbsentNotify: Sent to {$emailTo} for student {$student->id} ({$student->full_name}), class {$tuitionClass->name}, date {$today}.");

                } catch (\Exception $e) {
                    $this->error("   ❌ Failed to send email to {$emailTo}: " . $e->getMessage());
                    Log::error("AbsentNotify: Failed for student {$student->id} – " . $e->getMessage());
                }
            }
        }

        $this->info("Done. Total emails sent: {$emailsSent}");
        return self::SUCCESS;
    }
}
