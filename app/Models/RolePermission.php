<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'role',
        'permission_id',
        'can_view',
        'can_create',
        'can_edit',
        'can_delete',
        'can_export',
        'notes',
    ];

    protected $casts = [
        'can_view' => 'boolean',
        'can_create' => 'boolean',
        'can_edit' => 'boolean',
        'can_delete' => 'boolean',
        'can_export' => 'boolean',
    ];

    // หนึ่ง RolePermission belongsTo Permission
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    // Helper: ตรวจสอบว่า role มี permission นี้หรือไม่
    public static function hasPermission(string $role, string $moduleKey, string $action = 'view'): bool
    {
        // Admin มีทุกสิทธิ์เสมอ
        if ($role === 'admin') {
            return true;
        }

        $permission = self::where('role', $role)
            ->whereHas('permission', function ($query) use ($moduleKey) {
                $query->where('module_key', $moduleKey);
            })
            ->first();

        if (!$permission) {
            return false;
        }

        return $permission->{"can_{$action}"} ?? false;
    }

    // Helper: ดึง permissions ทั้งหมดของ role หนึ่ง
    public static function getForRole(string $role)
    {
        return self::with('permission')
            ->where('role', $role)
            ->get()
            ->pluck(function ($rp) {
                return $rp->permission->module_key . '.' . $rp->permission->permission_key;
            })
            ->toArray();
    }

    // Helper: ดึง modules ที่ role นี้สามารถดูได้
    public static function getVisibleModules(string $role): array
    {
        if ($role === 'admin') {
            return Permission::distinct()->pluck('module_key')->toArray();
        }

        return self::where('role', $role)
            ->where('can_view', true)
            ->with('permission')
            ->get()
            ->pluck('permission.module_key')
            ->unique()
            ->toArray();
    }
}
