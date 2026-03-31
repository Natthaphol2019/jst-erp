<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRecordLog extends Model
{
    protected $fillable = [
        'time_record_id', 'action', 'reason', 'old_data', 'new_data', 'changed_by'
    ];

    // แปลงข้อมูล JSON ให้เป็น Array อัตโนมัติเวลาดึงมาใช้งาน
    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function timeRecord()
    {
        return $this->belongsTo(TimeRecord::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
