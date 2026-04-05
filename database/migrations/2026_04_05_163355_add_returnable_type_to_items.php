<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // เปลี่ยน enum type จาก ['equipment', 'consumable'] เป็น ['disposable', 'returnable', 'equipment', 'consumable']
        DB::statement("ALTER TABLE items MODIFY COLUMN type ENUM('disposable', 'returnable', 'equipment', 'consumable') NOT NULL");

        // แปลงข้อมูลเดิม: consumable → disposable, equipment → returnable
        DB::table('items')->where('type', 'consumable')->update(['type' => 'disposable']);
        DB::table('items')->where('type', 'equipment')->update(['type' => 'returnable']);
    }

    public function down(): void
    {
        DB::table('items')->where('type', 'disposable')->update(['type' => 'consumable']);
        DB::table('items')->where('type', 'returnable')->update(['type' => 'equipment']);

        DB::statement("ALTER TABLE items MODIFY COLUMN type ENUM('equipment', 'consumable') NOT NULL");
    }
};
