<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActivityLogTrait;

class Position extends Model
{
    use HasFactory, SoftDeletes, ActivityLogTrait;

    protected $activityLogName = 'hr';

    // อนุญาตให้บันทึก 3 ฟิลด์นี้ได้
    protected $fillable = ['department_id', 'name', 'job_description'];

    // 1 ตำแหน่ง สังกัด 1 แผนก
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    // 1 ตำแหน่ง มีหลายพนักงาน
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}