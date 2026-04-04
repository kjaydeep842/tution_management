<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;
use App\Models\Student;
use Carbon\Carbon;

class TestWhatsAppMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a test attendance WhatsApp message';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService)
    {
        $phone = $this->argument('phone') ?: '919687748098';

        $this->info("Sending test WhatsApp message to {$phone}");

        // Create a fake student object for the notification service
        $student = new Student();
        $student->first_name = "Test";
        $student->last_name = "Student";
        $student->guardian_phone = $phone;

        // the signature is sendWhatsApp(Student $student, $status, $date, $className, $type, $assignment = null, $extraData = [])
        // We'll call the service by mocking a rawData payload and passing it to the private method indirectly, or we can just reflection
        
        $rawData = [
            'student' => $student,
            'status' => 'present',
            'date' => Carbon::now()->format('d-m-Y'),
            'className' => 'Class 10'
        ];

        // Access the private method using Reflection
        $method = new \ReflectionMethod(NotificationService::class, 'sendAttendanceTemplate');
        $method->setAccessible(true);
        
        $method->invoke($notificationService, $phone, $rawData);

        $this->info("Test message triggered. Check your laravel.log for errors if it didn't arrive.");
    }
}
