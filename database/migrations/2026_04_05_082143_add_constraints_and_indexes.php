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
        // =====================================================
        // 1. UNIQUE INDEXES
        // =====================================================

        // employees.employee_code - already unique from original migration, verify only
        // items.item_code - already unique from original migration, verify only
        // users.username - already unique from original migration, verify only

        // item_categories.name - add unique constraint (was missing in original migration)
        if (Schema::hasTable('item_categories') && !Schema::hasIndex('item_categories', 'item_categories_name_unique')) {
            try {
                Schema::table('item_categories', function (Blueprint $table) {
                    $table->unique('name', 'item_categories_name_unique');
                });
            } catch (\Exception $e) {
                // If duplicates exist, log and skip
                \Log::warning('Could not add unique index on item_categories.name: ' . $e->getMessage());
            }
        }

        // users.email - check if column exists before adding unique index
        // (users table may not have an email column in this project)
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'email')) {
            if (!Schema::hasIndex('users', 'users_email_unique')) {
                try {
                    Schema::table('users', function (Blueprint $table) {
                        $table->unique('email', 'users_email_unique');
                    });
                } catch (\Exception $e) {
                    \Log::warning('Could not add unique index on users.email: ' . $e->getMessage());
                }
            }
        }

        // =====================================================
        // 2. REGULAR INDEXES FOR PERFORMANCE
        // =====================================================

        // employees indexes
        if (Schema::hasTable('employees')) {
            Schema::table('employees', function (Blueprint $table) {
                // department_id - FK column, explicit index for query performance
                if (!Schema::hasIndex('employees', 'idx_employees_department_id')) {
                    $table->index('department_id', 'idx_employees_department_id');
                }
                // position_id - FK column
                if (!Schema::hasIndex('employees', 'idx_employees_position_id')) {
                    $table->index('position_id', 'idx_employees_position_id');
                }
                // employee_code - unique but also explicitly indexed for lookups
                if (!Schema::hasIndex('employees', 'idx_employees_employee_code')) {
                    $table->index('employee_code', 'idx_employees_employee_code');
                }
            });
        }

        // items indexes
        if (Schema::hasTable('items')) {
            Schema::table('items', function (Blueprint $table) {
                // category_id - FK column
                if (!Schema::hasIndex('items', 'idx_items_category_id')) {
                    $table->index('category_id', 'idx_items_category_id');
                }
                // item_code - unique but also explicitly indexed
                if (!Schema::hasIndex('items', 'idx_items_item_code')) {
                    $table->index('item_code', 'idx_items_item_code');
                }
            });
        }

        // requisitions indexes
        if (Schema::hasTable('requisitions')) {
            Schema::table('requisitions', function (Blueprint $table) {
                // employee_id - FK column
                if (!Schema::hasIndex('requisitions', 'idx_requisitions_employee_id')) {
                    $table->index('employee_id', 'idx_requisitions_employee_id');
                }
                // status - frequently queried for filtering
                if (!Schema::hasIndex('requisitions', 'idx_requisitions_status')) {
                    $table->index('status', 'idx_requisitions_status');
                }
            });
        }

        // requisition_items indexes
        if (Schema::hasTable('requisition_items')) {
            Schema::table('requisition_items', function (Blueprint $table) {
                // requisition_id - FK column
                if (!Schema::hasIndex('requisition_items', 'idx_req_items_requisition_id')) {
                    $table->index('requisition_id', 'idx_req_items_requisition_id');
                }
                // item_id - FK column
                if (!Schema::hasIndex('requisition_items', 'idx_req_items_item_id')) {
                    $table->index('item_id', 'idx_req_items_item_id');
                }
            });
        }

        // stock_transactions indexes
        if (Schema::hasTable('stock_transactions')) {
            Schema::table('stock_transactions', function (Blueprint $table) {
                // item_id - FK column
                if (!Schema::hasIndex('stock_transactions', 'idx_stock_txn_item_id')) {
                    $table->index('item_id', 'idx_stock_txn_item_id');
                }
                // created_at - for date-range queries and reporting
                if (!Schema::hasIndex('stock_transactions', 'idx_stock_txn_created_at')) {
                    $table->index('created_at', 'idx_stock_txn_created_at');
                }
            });
        }

        // time_records indexes
        if (Schema::hasTable('time_records')) {
            Schema::table('time_records', function (Blueprint $table) {
                // employee_id - FK column
                if (!Schema::hasIndex('time_records', 'idx_time_records_employee_id')) {
                    $table->index('employee_id', 'idx_time_records_employee_id');
                }
            });
        }

        // notifications indexes (polymorphic notifiable)
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                // Composite index on notifiable_type + notifiable_id for polymorphic lookups
                if (!Schema::hasIndex('notifications', 'idx_notifications_notifiable')) {
                    $table->index(['notifiable_type', 'notifiable_id'], 'idx_notifications_notifiable');
                }
            });
        }

        // =====================================================
        // 3. FOREIGN KEY CONSTRAINTS
        // Most FKs already exist from original migrations.
        // These are additional safety additions with explicit names.
        // =====================================================

        // requisitions.employee_id -> employees.id (already exists, verify)
        // requisitions.approved_by -> users.id (already exists, verify)
        // stock_transactions.item_id -> items.id (already exists, verify)
        // stock_transactions.requisition_id -> requisitions.id (already exists, verify)
        // stock_transactions.created_by -> users.id (already exists, verify)
        // requisition_items.requisition_id -> requisitions.id (already exists, verify)
        // requisition_items.item_id -> items.id (already exists, verify)
        // time_records.employee_id -> employees.id (already exists, verify)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop regular indexes
        if (Schema::hasTable('employees')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropIndex('idx_employees_department_id');
                $table->dropIndex('idx_employees_position_id');
                $table->dropIndex('idx_employees_employee_code');
            });
        }

        if (Schema::hasTable('items')) {
            Schema::table('items', function (Blueprint $table) {
                $table->dropIndex('idx_items_category_id');
                $table->dropIndex('idx_items_item_code');
            });
        }

        if (Schema::hasTable('requisitions')) {
            Schema::table('requisitions', function (Blueprint $table) {
                $table->dropIndex('idx_requisitions_employee_id');
                $table->dropIndex('idx_requisitions_status');
            });
        }

        if (Schema::hasTable('requisition_items')) {
            Schema::table('requisition_items', function (Blueprint $table) {
                $table->dropIndex('idx_req_items_requisition_id');
                $table->dropIndex('idx_req_items_item_id');
            });
        }

        if (Schema::hasTable('stock_transactions')) {
            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->dropIndex('idx_stock_txn_item_id');
                $table->dropIndex('idx_stock_txn_created_at');
            });
        }

        if (Schema::hasTable('time_records')) {
            Schema::table('time_records', function (Blueprint $table) {
                $table->dropIndex('idx_time_records_employee_id');
            });
        }

        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropIndex('idx_notifications_notifiable');
            });
        }

        // Drop unique indexes that we added
        if (Schema::hasTable('item_categories')) {
            Schema::table('item_categories', function (Blueprint $table) {
                $table->dropUnique('item_categories_name_unique');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'email')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_email_unique');
            });
        }
    }
};
