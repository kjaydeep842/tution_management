<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tuition_classes', function (Blueprint $table) {
            // Time when class starts, e.g. 12:00:00 – cron fires 30 min after this
            $table->time('class_time')->nullable()->after('schedule_info');
        });
    }

    public function down(): void
    {
        Schema::table('tuition_classes', function (Blueprint $table) {
            $table->dropColumn('class_time');
        });
    }
};
