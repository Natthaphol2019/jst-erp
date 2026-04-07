<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id', 'work_date', 'status', 'check_in_time',
        'check_out_time', 'source', 'is_locked', 'locked_by', 'remark','time_record_id','period','check_in_time','check_out_time'
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
        'work_date' => 'date',
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