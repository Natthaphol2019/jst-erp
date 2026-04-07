<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if we're using SQLite (for testing)
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support ENUM or MODIFY COLUMN
            return;
        }
        
        // เพิ่ม 'issued' เข้าไปใน enum status ของ requisitions
        DB::statement("ALTER TABLE requisitions MODIFY COLUMN status ENUM('pending','approved','rejected','returned_partial','returned_all','issued') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Check if we're using SQLite (for testing)
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            return;
        }
        
        // ลบ 'issued' ออก (ต้องแน่ใจว่าไม่มีข้อมูลที่ใช้ issued ก่อน)
        DB::statement("ALTER TABLE requisitions MODIFY COLUMN status ENUM('pending','approved','rejected','returned_partial','returned_all') NOT NULL DEFAULT 'pending'");
    }
};
