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
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->enum('transaction_type', ['in', 'out', 'return', 'adjust']);
            $table->integer('quantity'); // จำนวนที่เข้าหรือออก (ออกเป็นค่าลบ เข้าเป็นค่าบวก)
            $table->integer('balance'); // ยอดคงเหลือ ณ เวลานั้น
            $table->foreignId('requisition_id')->nullable()->constrained('requisitions'); // อ้างอิงจากใบเบิกไหน
            $table->foreignId('created_by')->constrained('users');
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
