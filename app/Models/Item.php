<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActivityLogTrait;

class Item extends Model
{
    use SoftDeletes, ActivityLogTrait;

    protected $activityLogName = 'inventory';
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

    protected $casts = [
        'current_stock' => 'integer',
        'min_stock' => 'integer',
    ];

    /**
     * Boot method: ตรวจสอบ current_stock ไม่ให้ติดลบ
     */
    protected static function booted(): void
    {
        static::saving(function ($item) {
            if ($item->current_stock < 0) {
                throw new \InvalidArgumentException(
                    "สต๊อกสินค้า {$item->name} ไม่สามารถติดลบได้ (ค่าที่พยายามบันทึก: {$item->current_stock})"
                );
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function transactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    /**
     * Get the URL for generating a barcode image.
     */
    public function getBarcodeUrl(): string
    {
        return route('inventory.items.barcode', $this->id);
    }

    /**
     * Get the URL for generating a QR code image.
     */
    public function getQrCodeUrl(): string
    {
        return route('inventory.items.qrcode', $this->id);
    }

    /**
     * Get the URL for the print barcode page.
     */
    public function getPrintBarcodeUrl(): string
    {
        return route('inventory.items.print-barcode', $this->id);
    }
}