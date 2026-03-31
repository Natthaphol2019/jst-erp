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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->onUpdate('cascade');
            $table->string('employee_code', 50)->unique();
            $table->string('prefix', 50)->nullable();
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('position', 100)->nullable();
            $table->date('start_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'resigned'])->default('active');
            $table->string('profile_image', 512)->nullable();
            $table->timestamps();
            $table->softDeletes(); // สำหรับลบข้อมูลแบบซ่อนไว้ (ไม่หายไปจริง)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
