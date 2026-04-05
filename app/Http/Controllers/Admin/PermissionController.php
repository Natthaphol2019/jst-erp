<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * แสดงหน้าตั้งค่าสิทธิ์ (Odoo-style Access Rights)
     */
    public function index(Request $request)
    {
        $roles = ['admin', 'hr', 'manager', 'inventory', 'employee'];
        $roleLabels = [
            'admin' => 'ผู้ดูแลระบบ',
            'hr' => 'ฝ่ายบุคคล (HR)',
            'manager' => 'ผู้จัดการ/ผู้บริหาร',
            'inventory' => 'ฝ่ายคลังสินค้า',
            'employee' => 'พนักงานทั่วไป',
        ];

        $selectedRole = $request->get('role', 'hr');

        // ดึง permissions grouped by module
        $modules = Permission::orderBy('module_key')->orderBy('sort_order')->get()->groupBy('module_key');

        // ดึง permissions ของ role ที่เลือก
        $rolePermissions = RolePermission::where('role', $selectedRole)
            ->with('permission')
            ->get()
            ->pluck(function ($rp) {
                return $rp->permission->module_key . '.' . $rp->permission->permission_key;
            }, function ($rp) {
                return $rp->permission->id;
            })
            ->toArray();

        // ดึง permissions ทั้งหมดของ role นี้
        $rolePermData = RolePermission::where('role', $selectedRole)->get()->keyBy('permission_id');

        // นับจำนวนผู้ใช้ในแต่ละ role
        $userCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        return view('admin.permissions.index', compact(
            'roles',
            'roleLabels',
            'selectedRole',
            'modules',
            'rolePermissions',
            'rolePermData',
            'userCounts'
        ));
    }

    /**
     * บันทึกการตั้งค่าสิทธิ์
     */
    public function update(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,hr,manager,inventory,employee',
            'permissions' => 'nullable|array',
            'permissions.*.permission_id' => 'nullable|exists:permissions,id',
            'permissions.*.can_view' => 'nullable|boolean',
            'permissions.*.can_create' => 'nullable|boolean',
            'permissions.*.can_edit' => 'nullable|boolean',
            'permissions.*.can_delete' => 'nullable|boolean',
            'permissions.*.can_export' => 'nullable|boolean',
        ]);

        $role = $request->role;
        $submittedPermissions = $request->permissions ?? [];

        // Admin มีทุกสิทธิ์เสมอ - ไม่ต้องอัปเดต
        if ($role === 'admin') {
            return redirect()->back()->with('success', 'Admin มีทุกสิทธิ์อยู่แล้ว ไม่ต้องตั้งค่า');
        }

        // ดึง permissions ทั้งหมดจาก database
        $allPermissions = \App\Models\Permission::all();

        DB::beginTransaction();
        try {
            foreach ($allPermissions as $permission) {
                $permId = $permission->id;
                $permData = $submittedPermissions[$permId] ?? [];

                // ถ้าไม่มีการส่งมา (ไม่ได้ขยาย accordion) ให้ใช้ค่าเดิม
                // ถ้ามีการส่งมา ใช้ค่าที่ส่งมา
                RolePermission::updateOrCreate(
                    [
                        'role' => $role,
                        'permission_id' => $permId,
                    ],
                    [
                        'can_view' => isset($permData['can_view']) ? (bool)$permData['can_view'] : false,
                        'can_create' => isset($permData['can_create']) ? (bool)$permData['can_create'] : false,
                        'can_edit' => isset($permData['can_edit']) ? (bool)$permData['can_edit'] : false,
                        'can_delete' => isset($permData['can_delete']) ? (bool)$permData['can_delete'] : false,
                        'can_export' => isset($permData['can_export']) ? (bool)$permData['can_export'] : false,
                    ]
                );
            }

            DB::commit();

            // ล้าง cache permissions
            cache()->forget("permissions.{$role}");

            return redirect()->back()->with('success', "บันทึกสิทธิ์ของ \"{$role}\" เรียบร้อยแล้ว");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    /**
     * Reset permissions ของ role กลับไปค่าเริ่มต้น
     */
    public function reset(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,hr,manager,inventory,employee',
        ]);

        $role = $request->role;

        if ($role === 'admin') {
            return redirect()->back()->with('error', 'ไม่สามารถ reset Admin ได้');
        }

        // ลบของเก่าแล้ว seed ใหม่
        RolePermission::where('role', $role)->delete();

        // สร้างใหม่จาก PermissionSeeder
        $seeder = new \Database\Seeders\PermissionSeeder();
        $seeder->assignPermissionsForRole($role);

        cache()->forget("permissions.{$role}");

        return redirect()->back()->with('success', "Reset สิทธิ์ของ \"{$role}\" กลับไปค่าเริ่มต้นแล้ว");
    }

    /**
     * API: ตรวจสอบ permission (สำหรับใช้ใน middleware/controller)
     */
    public static function checkPermission(string $role, string $moduleKey, string $action = 'view'): bool
    {
        // Admin มีทุกสิทธิ์
        if ($role === 'admin') {
            return true;
        }

        // เช็คจาก cache ก่อน
        $cacheKey = "permissions.{$role}.{$moduleKey}.{$action}";
        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $hasPermission = RolePermission::hasPermission($role, $moduleKey, $action);

        // Cache 5 นาที
        cache()->put($cacheKey, $hasPermission, 300);

        return $hasPermission;
    }

    /**
     * API: ดึง modules ที่ role นี้ดูได้ (สำหรับ sidebar)
     */
    public static function getVisibleModules(string $role): array
    {
        if ($role === 'admin') {
            return Permission::distinct()->pluck('module_key')->toArray();
        }

        $cacheKey = "permissions.modules.{$role}";
        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $modules = RolePermission::getVisibleModules($role);

        cache()->put($cacheKey, $modules, 300);

        return $modules;
    }
}
