<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification
{
    use Queueable;

    public function __construct(public Item $item)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'low_stock',
            'icon' => 'bi-arrow-down-circle',
            'color' => 'danger',
            'title' => 'สินค้าคงเหลือต่ำกว่าขั้นต่ำ',
            'message' => "{$this->item->name} คงเหลือ {$this->item->current_stock} {$this->item->unit} (ขั้นต่ำ: {$this->item->min_stock})",
            'action_url' => route('inventory.items.edit', $this->item->id),
            'action_text' => 'จัดการสินค้า',
            'item_id' => $this->item->id,
        ];
    }
}
