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
        Schema::create('time_record_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_record_id')->constrained('time_records')->cascadeOnDelete();
            $table->string('action', 50); // เช่น 'update', 'manual_insert'
            $table->text('reason')->nullable(); // เหตุผลที่แก้ไข
            $table->json('old_data')->nullable(); // เก็บข้อมูลเดิมก่อนแก้ในรูปแบบ JSON
            $table->json('new_data')->nullable(); // เก็บข้อมูลใหม่หลังแก้ในรูปแบบ JSON
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete(); // User คนไหนเป็นคนแก้ไข
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_record_logs');
    }
};
