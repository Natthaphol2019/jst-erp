<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('item_categories');
            $table->string('item_code', 50)->unique();
            $table->string('asset_number', 100)->nullable()->unique()->comment('เลขครุภัณฑ์ สำหรับอุปกรณ์'); // 🌟 เพิ่มฟิลด์นี้
            $table->string('name', 255);
            $table->enum('type', ['disposable', 'returnable', 'equipment', 'consumable']); // แยกยืมคืน กับ สิ้นเปลือง
            $table->string('unit', 50); // เช่น ชิ้น, ลิตร, กก.
            $table->integer('current_stock')->default(0);
            $table->integer('min_stock')->default(0);
            $table->string('location', 100)->nullable();
            $table->string('image_url', 512)->nullable();
            $table->enum('status', ['available', 'unavailable', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};