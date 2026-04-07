<?php

namespace App\Models;

use App\Traits\ActivityLogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use ActivityLogTrait, SoftDeletes, HasFactory;

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
        'status',
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

    /**
     * ตรวจสอบว่าเป็นสินค้าประเภทใช้แล้วหมดไป (เบิกได้เลย ไม่ต้องคืน)
     */
    public function isDisposable(): bool
    {
        return $this->type === 'disposable';
    }

    /**
     * ตรวจสอบว่าเป็นสินค้าประเภทต้องคืน (ยืม-คืน)
     */
    public function isReturnable(): bool
    {
        return $this->type === 'returnable';
    }

    /**
     * Label ของ type สำหรับแสดงผล
     */
    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'disposable' => 'ใช้แล้วหมดไป',
            'returnable' => 'ยืม-คืน',
            'equipment' => 'อุปกรณ์',
            'consumable' => 'สิ้นเปลือง',
            default => $this->type,
        };
    }

    /**
     * Badge color สำหรับ type
     */
    public function getTypeBadgeStyle(): array
    {
        return match ($this->type) {
            'disposable' => ['bg' => 'rgba(56,189,248,0.12)', 'color' => '#38bdf8'],
            'returnable' => ['bg' => 'rgba(167,139,250,0.12)', 'color' => '#a78bfa'],
            default => ['bg' => 'rgba(107,114,128,0.12)', 'color' => '#9ca3af'],
        };
    }
}
