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
        Schema::create('time_record_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_record_id')->constrained('time_records')->cascadeOnDelete();
            $table->enum('period_type', ['morning', 'afternoon', 'overtime']);
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->timestamps();

            $table->unique(['time_record_id', 'period_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_record_details');
    }
};
