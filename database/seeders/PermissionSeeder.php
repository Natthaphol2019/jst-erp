<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->createPermissions();
        $this->assignDefaultRolePermissions();

        $this->command->info('✅ Permissions seeded successfully!');
    }

    private function createPermissions(): void
    {
        $permissions = [
            // ==================== DASHBOARD ====================
            ['hr.dashboard', 'แดชบอร์ด HR', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1],
            ['admin.dashboard', 'แดชบอร์ด Admin', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1],
            ['manager.dashboard', 'แดชบอร์ด Manager', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1],
            ['inventory.dashboard', 'แดชบอร์ดคลังสินค้า', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1],
            ['employee.dashboard', 'แดชบอร์ดพนักงาน', 'fas fa-chart-pie', 'view', 'ดูแดชบอร์ด', 1],

            // ==================== HR - จัดการพนักงาน ====================
            ['hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'view', 'ดูรายการ', 1],
            ['hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'create', 'เพิ่มพนักงาน', 2],
            ['hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'edit', 'แก้ไขข้อมูล', 3],
            ['hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'delete', 'ลบพนักงาน', 4],
            ['hr.employees', 'จัดการพนักงาน', 'fas fa-users', 'export', 'Export Excel', 5],

            ['hr.departments', 'จัดการแผนก', 'fas fa-building', 'view', 'ดูรายการ', 1],
            ['hr.departments', 'จัดการแผนก', 'fas fa-building', 'create', 'เพิ่มแผนก', 2],
            ['hr.departments', 'จัดการแผนก', 'fas fa-building', 'edit', 'แก้ไขแผนก', 3],
            ['hr.departments', 'จัดการแผนก', 'fas fa-building', 'delete', 'ลบแผนก', 4],

            ['hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'view', 'ดูรายการ', 1],
            ['hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'create', 'เพิ่มตำแหน่ง', 2],
            ['hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'edit', 'แก้ไขตำแหน่ง', 3],
            ['hr.positions', 'จัดการตำแหน่ง', 'fas fa-briefcase', 'delete', 'ลบตำแหน่ง', 4],

            // ==================== HR - ระบบลงเวลา ====================
            ['hr.time_records', 'บันทึกเวลาจากบัตร', 'fas fa-clock', 'view', 'ดู/บันทึกเวลา', 1],
            ['hr.time_records', 'บันทึกเวลาจากบัตร', 'fas fa-clock', 'create', 'เพิ่มบันทึก', 2],
            ['hr.time_records', 'บันทึกเวลาจากบัตร', 'fas fa-clock', 'edit', 'แก้ไขบันทึก', 3],
            ['hr.time_records', 'บันทึกเวลาจากบัตร', 'fas fa-clock', 'delete', 'ลบบันทึก', 4],

            ['hr.time_summary', 'รายงานสรุปรายเดือน', 'fas fa-chart-line', 'view', 'ดูรายงาน', 1],
            ['hr.time_summary', 'รายงานสรุปรายเดือน', 'fas fa-chart-line', 'export', 'Export Excel', 2],

            ['hr.time_lock', 'ปิดงวดเวลาทำงาน', 'fas fa-lock', 'view', 'ดู/ปิดงวด', 1],
            ['hr.time_lock', 'ปิดงวดเวลาทำงาน', 'fas fa-lock', 'create', 'ล็อกงวด', 2],

            ['hr.time_logs', 'ประวัติแก้ไขเวลา', 'fas fa-history', 'view', 'ดูประวัติ', 1],

            // ==================== INVENTORY - คลังสินค้า ====================
            ['inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'view', 'ดูรายการ', 1],
            ['inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'create', 'เพิ่มสินค้า', 2],
            ['inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'edit', 'แก้ไขสินค้า', 3],
            ['inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'delete', 'ลบสินค้า', 4],
            ['inventory.items', 'จัดการสินค้า', 'fas fa-box-open', 'export', 'Export Excel', 5],

            ['inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'view', 'ดูรายการ', 1],
            ['inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'create', 'เพิ่มหมวดหมู่', 2],
            ['inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'edit', 'แก้ไขหมวดหมู่', 3],
            ['inventory.categories', 'จัดการหมวดหมู่สินค้า', 'fas fa-tags', 'delete', 'ลบหมวดหมู่', 4],

            ['inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'view', 'ดูรายการ', 1],
            ['inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'create', 'สร้างใบยืม', 2],
            ['inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'edit', 'แก้ไขใบยืม', 3],
            ['inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'delete', 'ลบใบยืม', 4],
            ['inventory.borrowing', 'รายการยืม-คืน', 'fas fa-hand-holding', 'export', 'Export Excel', 5],

            ['inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'view', 'ดูรายการ', 1],
            ['inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'create', 'สร้างใบเบิก', 2],
            ['inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'edit', 'แก้ไขใบเบิก', 3],
            ['inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'delete', 'ลบใบเบิก', 4],
            ['inventory.requisition', 'รายการเบิก', 'fas fa-clipboard-list', 'export', 'Export Excel', 5],

            ['inventory.transactions', 'ประวัติเคลื่อนไหวสต๊อก', 'fas fa-exchange-alt', 'view', 'ดูประวัติ', 1],
            ['inventory.transactions', 'ประวัติเคลื่อนไหวสต๊อก', 'fas fa-exchange-alt', 'export', 'Export Excel', 2],

            ['inventory.stock_summary', 'สรุปยอดคงเหลือ', 'fas fa-balance-scale', 'view', 'ดูสรุป', 1],
            ['inventory.stock_summary', 'สรุปยอดคงเหลือ', 'fas fa-balance-scale', 'export', 'Export Excel', 2],

            // ==================== ADMIN - จัดการระบบ ====================
            ['admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'view', 'ดูรายการ', 1],
            ['admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'create', 'เพิ่มผู้ใช้', 2],
            ['admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'edit', 'แก้ไขผู้ใช้', 3],
            ['admin.users', 'จัดการผู้ใช้งาน', 'fas fa-user-shield', 'delete', 'ลบผู้ใช้', 4],

            ['admin.permissions', 'ตั้งค่าสิทธิ์การใช้งาน', 'fas fa-key', 'view', 'ดู/ตั้งค่าสิทธิ์', 1],
            ['admin.permissions', 'ตั้งค่าสิทธิ์การใช้งาน', 'fas fa-key', 'edit', 'แก้ไขสิทธิ์', 2],

            ['admin.activity_logs', 'บันทึกกิจกรรม', 'fas fa-clipboard-check', 'view', 'ดูบันทึก', 1],
            ['admin.activity_logs', 'บันทึกกิจกรรม', 'fas fa-clipboard-check', 'export', 'Export Excel', 2],

            ['admin.backups', 'สำรองข้อมูล', 'fas fa-database', 'view', 'ดู/สร้าง Backup', 1],
            ['admin.backups', 'สำรองข้อมูล', 'fas fa-database', 'create', 'สร้าง Backup', 2],
            ['admin.backups', 'สำรองข้อมูล', 'fas fa-database', 'delete', 'ลบ Backup', 3],

            ['admin.health', 'ตรวจสอบสถานะระบบ', 'fas fa-heartbeat', 'view', 'ดูสถานะ', 1],

            ['admin.imports', 'นำเข้าข้อมูล', 'fas fa-file-import', 'view', 'นำเข้าข้อมูล', 1],
            ['admin.imports', 'นำเข้าข้อมูล', 'fas fa-file-import', 'create', 'อัปโหลดไฟล์', 2],

            ['admin.exports', 'ส่งออกข้อมูล', 'fas fa-file-export', 'view', 'ส่งออกข้อมูล', 1],

            // ==================== PROFILE - โปรไฟล์ ====================
            ['profile.edit', 'แก้ไขโปรไฟล์', 'fas fa-user-edit', 'view', 'แก้ไขข้อมูลส่วนตัว', 1],
            ['profile.password', 'เปลี่ยนรหัสผ่าน', 'fas fa-lock', 'view', 'เปลี่ยนรหัสผ่าน', 1],

            // ==================== NOTIFICATIONS - การแจ้งเตือน ====================
            ['notifications', 'การแจ้งเตือน', 'fas fa-bell', 'view', 'ดูการแจ้งเตือน', 1],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['module_key' => $perm[0], 'permission_key' => $perm[3]],
                [
                    'module_name' => $perm[1],
                    'module_icon' => $perm[2],
                    'permission_name' => $perm[4],
                    'sort_order' => $perm[5],
                ]
            );
        }

        $this->command->info('✅ Created ' . Permission::count() . ' permissions');
    }

    private function assignDefaultRolePermissions(): void
    {
        $roles = ['admin', 'hr', 'manager', 'inventory', 'employee'];

        foreach ($roles as $role) {
            $this->assignPermissionsForRole($role);
        }

        $this->command->info('✅ Assigned permissions for all roles');
    }

    private function assignPermissionsForRole(string $role): void
    {
        // ลบของเก่าก่อน
        RolePermission::where('role', $role)->delete();

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $defaults = $this->getDefaultPermissions($role, $permission->module_key);

            RolePermission::create([
                'role' => $role,
                'permission_id' => $permission->id,
                'can_view' => $defaults['view'] ?? false,
                'can_create' => $defaults['create'] ?? false,
                'can_edit' => $defaults['edit'] ?? false,
                'can_delete' => $defaults['delete'] ?? false,
                'can_export' => $defaults['export'] ?? false,
            ]);
        }
    }

    private function getDefaultPermissions(string $role, string $moduleKey): array
    {
        // ==================== ADMIN - ทุกสิทธิ์ทุกอย่าง ====================
        if ($role === 'admin') {
            return ['view' => true, 'create' => true, 'edit' => true, 'delete' => true, 'export' => true];
        }

        // ==================== HR - ฝ่ายบุคคล ====================
        if ($role === 'hr') {
            return match ($moduleKey) {
                'hr.dashboard' => ['view' => true],
                'hr.employees' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true, 'export' => true],
                'hr.departments' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true],
                'hr.positions' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true],
                'hr.time_records' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true],
                'hr.time_summary' => ['view' => true, 'export' => true],
                'hr.time_lock' => ['view' => true, 'create' => true],
                'hr.time_logs' => ['view' => true],
                'profile.edit' => ['view' => true],
                'profile.password' => ['view' => true],
                'notifications' => ['view' => true],
                default => [],
            };
        }

        // ==================== MANAGER - ผู้จัดการ (ดูรายงาน) ====================
        if ($role === 'manager') {
            return match ($moduleKey) {
                'manager.dashboard' => ['view' => true],
                'hr.dashboard' => ['view' => true],
                'hr.employees' => ['view' => true, 'export' => true], // ดูได้อย่างเดียว
                'hr.time_summary' => ['view' => true, 'export' => true],
                'hr.time_logs' => ['view' => true],
                'inventory.stock_summary' => ['view' => true, 'export' => true],
                'inventory.transactions' => ['view' => true, 'export' => true],
                'inventory.borrowing' => ['view' => true, 'export' => true],
                'inventory.requisition' => ['view' => true, 'export' => true],
                'profile.edit' => ['view' => true],
                'profile.password' => ['view' => true],
                'notifications' => ['view' => true],
                default => [],
            };
        }

        // ==================== INVENTORY - คลังสินค้า ====================
        if ($role === 'inventory') {
            return match ($moduleKey) {
                'inventory.dashboard' => ['view' => true],
                'inventory.items' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true, 'export' => true],
                'inventory.categories' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true],
                'inventory.borrowing' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true, 'export' => true],
                'inventory.requisition' => ['view' => true, 'create' => true, 'edit' => true, 'delete' => true, 'export' => true],
                'inventory.transactions' => ['view' => true, 'export' => true],
                'inventory.stock_summary' => ['view' => true, 'export' => true],
                'profile.edit' => ['view' => true],
                'profile.password' => ['view' => true],
                'notifications' => ['view' => true],
                default => [],
            };
        }

        // ==================== EMPLOYEE - พนักงานทั่วไป ====================
        if ($role === 'employee') {
            return match ($moduleKey) {
                'employee.dashboard' => ['view' => true],
                'inventory.borrowing' => ['view' => true, 'create' => true], // ยืมของได้
                'inventory.requisition' => ['view' => true, 'create' => true], // เบิกของได้
                'profile.edit' => ['view' => true],
                'profile.password' => ['view' => true],
                'notifications' => ['view' => true],
                default => [],
            };
        }

        return [];
    }
}
