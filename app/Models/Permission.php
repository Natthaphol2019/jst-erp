<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'module_key',
        'module_name',
        'module_icon',
        'permission_key',
        'permission_name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // หนึ่ง Permission มีหลาย RolePermission
    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    // ดึง permissions grouped by module
    public static function groupedByModule()
    {
        return self::orderBy('module_key')->orderBy('sort_order')->get()->groupBy('module_key');
    }
}
