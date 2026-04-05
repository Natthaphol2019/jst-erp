<?php

use App\Models\RolePermission;

/**
 * ตรวจสอบ permission ของ user ปัจจุบัน
 */
if (!function_exists('can_permission')) {
    function can_permission(string $moduleKey, string $action = 'view'): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return auth()->user()->hasPermission($moduleKey, $action);
    }
}

/**
 * ตรวจสอบว่า user สามารถดู module นี้ได้หรือไม่
 */
if (!function_exists('can_view')) {
    function can_view(string $moduleKey): bool
    {
        return can_permission($moduleKey, 'view');
    }
}

/**
 * ตรวจสอบว่า user สามารถสร้างได้หรือไม่
 */
if (!function_exists('can_create')) {
    function can_create(string $moduleKey): bool
    {
        return can_permission($moduleKey, 'create');
    }
}

/**
 * ตรวจสอบว่า user สามารถแก้ไขได้หรือไม่
 */
if (!function_exists('can_edit')) {
    function can_edit(string $moduleKey): bool
    {
        return can_permission($moduleKey, 'edit');
    }
}

/**
 * ตรวจสอบว่า user สามารถลบได้หรือไม่
 */
if (!function_exists('can_delete')) {
    function can_delete(string $moduleKey): bool
    {
        return can_permission($moduleKey, 'delete');
    }
}

/**
 * ตรวจสอบว่า user สามารถ export ได้หรือไม่
 */
if (!function_exists('can_export')) {
    function can_export(string $moduleKey): bool
    {
        return can_permission($moduleKey, 'export');
    }
}

/**
 * ดึง modules ที่ user ปัจจุบันดูได้
 */
if (!function_exists('visible_modules')) {
    function visible_modules(): array
    {
        if (!auth()->check()) {
            return [];
        }

        return auth()->user()->getVisibleModules();
    }
}

/**
 * แสดงเนื้อหาเฉพาะ user ที่มี permission
 */
if (!function_exists('has_permission')) {
    function has_permission(string $moduleKey, string $action = 'view'): bool
    {
        return can_permission($moduleKey, $action);
    }
}
