<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

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