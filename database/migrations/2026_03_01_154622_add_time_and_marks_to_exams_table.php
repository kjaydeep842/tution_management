<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            if (Schema::hasColumn('exams', 'title')) {
                $table->dropColumn('title');
            }
            $table->string('name')->after('id');
            $table->string('subject')->after('name');
            $table->decimal('total_marks', 8, 2)->default(100)->after('exam_date');
            $table->decimal('passing_marks', 8, 2)->default(35)->after('total_marks');
            $table->time('start_time')->nullable()->after('exam_date');
            $table->time('end_time')->nullable()->after('start_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->dropColumn(['name', 'subject', 'total_marks', 'passing_marks', 'start_time', 'end_time']);
        });
    }
};
