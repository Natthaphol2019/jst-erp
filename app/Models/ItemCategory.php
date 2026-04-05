<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActivityLogTrait;

class ItemCategory extends Model
{
    use SoftDeletes, ActivityLogTrait;

    protected $activityLogName = 'inventory';

    protected $fillable = ['name', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
