<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'item_id',
        'transaction_type',
        'quantity',
        'balance',
        'requisition_id',
        'created_by',
        'remark'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
