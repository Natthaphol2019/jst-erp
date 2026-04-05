<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActivityLogTrait;

class Requisition extends Model
{
    use SoftDeletes, ActivityLogTrait;

    protected $activityLogName = 'inventory';
    protected $fillable = [
        'employee_id',
        'req_type',
        'status',
        'req_date',
        'due_date',
        'note',
        'approved_by'
    ];

    protected $casts = [
        'req_date' => 'date',
        'due_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function items()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
