<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // เพิ่ม soft deletes ให้ตาราง items
        Schema::table('items', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });

        // เพิ่ม soft deletes ให้ตาราง item_categories
        Schema::table('item_categories', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });

        // เพิ่ม soft deletes ให้ตาราง requisitions
        Schema::table('requisitions', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });

        // เพิ่ม soft deletes ให้ตาราง requisition_items
        Schema::table('requisition_items', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });

        // เพิ่ม soft deletes ให้ตาราง departments
        Schema::table('departments', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });

        // เพิ่ม soft deletes ให้ตาราง positions
        Schema::table('positions', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('item_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('requisition_items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
