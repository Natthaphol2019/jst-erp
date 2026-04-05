<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     * เพิ่ม CHECK constraint ป้องกัน current_stock ติดลบ
     * หมายเหตุ: MySQL 8.0.16+ รองรับ CHECK constraint
     * เวอร์ชันเก่ากว่าจะ ignore constraint แต่ validation ยังท างานที่ application level
     */
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE items ADD CONSTRAINT positive_stock CHECK (current_stock >= 0)');
        } catch (\Exception $e) {
            // MySQL เวอร์ชันเก่าไม่รองรับ CHECK constraint
            // Application-level validation จะป้องกันแทน
            Log::info('Migration: CHECK constraint not supported on this MySQL version. Application-level validation will prevent negative stock.', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE items DROP CONSTRAINT positive_stock');
        } catch (\Exception $e) {
            //_constraint อาจไม่มีใน MySQL เวอร์ชันเก่า
            Log::info('Migration: Dropping CHECK constraint failed (may not exist).', [
                'error' => $e->getMessage(),
            ]);
        }
    }
};
