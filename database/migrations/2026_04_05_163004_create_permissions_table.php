<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('module_key'); // เช่น 'hr.employees', 'inventory.items'
            $table->string('module_name'); // ชื่อที่แสดง เช่น 'จัดการพนักงาน'
            $table->string('module_icon')->nullable(); // icon class
            $table->string('permission_key'); // เช่น 'view', 'create', 'edit', 'delete'
            $table->string('permission_name'); // ชื่อที่แสดง เช่น 'ดู', 'สร้าง', 'แก้ไข', 'ลบ'
            $table->integer('sort_order')->default(0); // ลำดับการแสดงผล
            $table->timestamps();

            $table->unique(['module_key', 'permission_key']);
            $table->index('module_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
