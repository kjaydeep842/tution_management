<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tuition_classes', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete()->after('id');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete()->after('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('tuition_classes', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['branch_id', 'teacher_id']);
        });
    }
};
