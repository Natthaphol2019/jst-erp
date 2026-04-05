<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL: Need to drop and recreate enum column
        Schema::table('stock_transactions', function (Blueprint $table) {
            // Add new transaction types
            DB::statement("ALTER TABLE stock_transactions MODIFY COLUMN transaction_type ENUM('in', 'out', 'return', 'adjust', 'borrow_out', 'borrow_return', 'consume_out') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            DB::statement("ALTER TABLE stock_transactions MODIFY COLUMN transaction_type ENUM('in', 'out', 'return', 'adjust') NOT NULL");
        });
    }
};
