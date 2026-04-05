<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActivityLogTrait;

class Employee extends Model
{
    use HasFactory, SoftDeletes, ActivityLogTrait;

    protected $activityLogName = 'hr';

    protected $fillable = [
        'department_id',
        'position_id',
        'employee_code',
        'prefix',
        'firstname',
        'lastname',
        'gender',
        'start_date',
        'status',
        'profile_image',
        'phone',
        'address'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function timeRecords()
    {
        return $this->hasMany(TimeRecord::class);
    }
}