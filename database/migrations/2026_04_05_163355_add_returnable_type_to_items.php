<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if we're using SQLite (for testing)
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support ENUM or MODIFY COLUMN
            // Just convert data - validation is handled at app level
            DB::table('items')->where('type', 'consumable')->update(['type' => 'disposable']);
            DB::table('items')->where('type', 'equipment')->update(['type' => 'returnable']);
            return;
        }
        
        // MySQL: Change enum and convert data
        DB::statement("ALTER TABLE items MODIFY COLUMN type ENUM('disposable', 'returnable', 'equipment', 'consumable') NOT NULL");

        // แปลงข้อมูลเดิม: consumable → disposable, equipment → returnable
        DB::table('items')->where('type', 'consumable')->update(['type' => 'disposable']);
        DB::table('items')->where('type', 'equipment')->update(['type' => 'returnable']);
    }

    public function down(): void
    {
        // Check if we're using SQLite (for testing)
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support ENUM or MODIFY COLUMN
            DB::table('items')->where('type', 'disposable')->update(['type' => 'consumable']);
            DB::table('items')->where('type', 'returnable')->update(['type' => 'equipment']);
            return;
        }
        
        // MySQL: Revert changes
        DB::table('items')->where('type', 'disposable')->update(['type' => 'consumable']);
        DB::table('items')->where('type', 'returnable')->update(['type' => 'equipment']);

        DB::statement("ALTER TABLE items MODIFY COLUMN type ENUM('equipment', 'consumable') NOT NULL");
    }
};
