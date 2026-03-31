<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'item_code',
        'name',
        'type',
        'unit',
        'current_stock',
        'min_stock',
        'location',
        'image_url',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function transactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}