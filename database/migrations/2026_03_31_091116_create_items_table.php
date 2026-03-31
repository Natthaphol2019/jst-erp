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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('item_categories');
            $table->string('item_code', 50)->unique();
            $table->string('name', 255);
            $table->enum('type', ['equipment', 'consumable']); // แยกยืมคืน กับ สิ้นเปลือง
            $table->string('unit', 50); // เช่น ชิ้น, ลิตร, กก.
            $table->integer('current_stock')->default(0);
            $table->integer('min_stock')->default(0);
            $table->string('location', 100)->nullable();
            $table->string('image_url', 512)->nullable();
            $table->enum('status', ['available', 'unavailable', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
