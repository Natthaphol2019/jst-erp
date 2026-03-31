<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRecord extends Model
{
    protected $fillable = [
        'employee_id', 'work_date', 'status', 'check_in_time', 
        'check_out_time', 'source', 'is_locked', 'locked_by', 'remark'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(TimeRecordDetail::class);
    }

    public function logs()
    {
        return $this->hasMany(TimeRecordLog::class);
    }
}