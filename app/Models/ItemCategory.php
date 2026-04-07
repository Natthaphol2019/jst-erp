<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActivityLogTrait;

class ItemCategory extends Model
{
    use SoftDeletes, ActivityLogTrait, HasFactory;

    protected $activityLogName = 'inventory';

    protected $fillable = ['name', 'code_prefix', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
