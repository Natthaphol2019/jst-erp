<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'next_department_id'];

    // 1 แผนก มีหลายพนักงาน
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // 1 แผนก สามารถมีแผนกถัดไปได้
    public function nextDepartment()
    {
        return $this->belongsTo(Department::class, 'next_department_id');
    }
    // 1 แผนก มีหลายตำแหน่งงาน
    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}