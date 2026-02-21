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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_id')->constrained('fees');
            $table->foreignId('student_id')->constrained('students');
            $table->decimal('amount', 10, 2);
            $table->string('payment_mode'); // Cash, Online, Cheque
            $table->string('txn_id')->nullable();
            $table->date('paid_on');
            $table->string('receipt_no')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
