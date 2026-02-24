<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/*
|--------------------------------------------------------------------------
| Absent Student Email Notifier — runs every working day (Mon–Fri)
|--------------------------------------------------------------------------
| The command checks each class whose (class_time + 30 min) matches the
| current minute and sends absence emails to parents.
*/
Schedule::command('attendance:notify-absent')
    ->everyMinute()
    ->weekdays()
    ->withoutOverlapping();

Schedule::command('attendance:send-monthly')
    ->monthlyOn(
        \App\Models\Setting::get('attendance_report_day', 1),
        \App\Models\Setting::get('attendance_report_time', '00:00')
    )
    ->withoutOverlapping();
