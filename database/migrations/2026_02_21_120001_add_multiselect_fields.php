<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tuition_classes', function (Blueprint $table) {
            // Store multiple branch IDs as JSON
            $table->text('branch_ids')->nullable()->after('branch_id');
        });

        Schema::table('teachers', function (Blueprint $table) {
            // Store multiple subject specialisations as JSON
            $table->text('subject_ids')->nullable()->after('subject_specialisation');
        });
    }

    public function down(): void
    {
        Schema::table('tuition_classes', function (Blueprint $table) {
            $table->dropColumn('branch_ids');
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('subject_ids');
        });
    }
};
