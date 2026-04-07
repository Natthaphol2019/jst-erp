<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'employee_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // แผนกที่ผู้ใช้เป็นหัวหน้า
    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    // ==========================================
    // Permission Helper Methods
    // ==========================================

    // ตรวจสอบว่ามี permission หรือไม่
    public function hasPermission(string $moduleKey, string $action = 'view'): bool
    {
        return RolePermission::hasPermission($this->role, $moduleKey, $action);
    }

    // ตรวจสอบว่าสามารถดู module นี้ได้หรือไม่
    public function canView(string $moduleKey): bool
    {
        return $this->hasPermission($moduleKey, 'view');
    }

    // ตรวจสอบว่าสามารถสร้างได้หรือไม่
    public function canCreate(string $moduleKey): bool
    {
        return $this->hasPermission($moduleKey, 'create');
    }

    // ตรวจสอบว่าสามารถแก้ไขได้หรือไม่
    public function canEdit(string $moduleKey): bool
    {
        return $this->hasPermission($moduleKey, 'edit');
    }

    // ตรวจสอบว่าสามารถลบได้หรือไม่
    public function canDelete(string $moduleKey): bool
    {
        return $this->hasPermission($moduleKey, 'delete');
    }

    // ตรวจสอบว่าสามารถ export ได้หรือไม่
    public function canExport(string $moduleKey): bool
    {
        return $this->hasPermission($moduleKey, 'export');
    }

    // ดึง modules ที่ user นี้สามารถดูได้
    public function getVisibleModules(): array
    {
        return RolePermission::getVisibleModules($this->role);
    }

    // ตรวจสอบว่าเป็น admin (มีทุกสิทธิ์)
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}