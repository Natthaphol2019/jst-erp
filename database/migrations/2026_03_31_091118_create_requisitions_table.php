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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->enum('req_type', ['borrow', 'consume']); // บอกว่าใบนี้เป็นการยืม หรือเบิกใช้
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned_partial', 'returned_all'])->default('pending');
            $table->date('req_date');
            $table->date('due_date')->nullable(); // กำหนดคืน (สำหรับยืมอุปกรณ์)
            $table->text('note')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
