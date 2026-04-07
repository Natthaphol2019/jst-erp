<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActivityLogTrait;

class RequisitionItem extends Model
{
    use SoftDeletes, ActivityLogTrait;

    protected $activityLogName = 'inventory';
    protected $fillable = [
        'requisition_id',
        'item_id',
        'quantity_requested',
        'quantity_returned',
        'return_images'
    ];

    protected $casts = [
        'return_images' => 'array',
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
