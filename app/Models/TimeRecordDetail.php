<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRecordDetail extends Model
{
    protected $fillable = [
        'time_record_id',
        'period_type',
        'check_in_time',
        'check_out_time'
    ];

    public function timeRecord()
    {
        return $this->belongsTo(TimeRecord::class);
    }
}