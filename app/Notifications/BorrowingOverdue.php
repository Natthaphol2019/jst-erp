<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BorrowingOverdue extends Notification
{
    use Queueable;

    public function __construct(public Requisition $borrowing)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $requester = $this->borrowing->employee;
        $name = $requester ? "{$requester->firstname} {$requester->lastname}" : 'ไม่ระบุ';

        return [
            'type' => 'borrowing_overdue',
            'icon' => 'bi-exclamation-triangle',
            'color' => 'warning',
            'title' => 'ใบยืมเกินกำหนดคืน',
            'message' => "{$name} ยังไม่ได้คืนสินค้า (ครบกำหนด: {$this->borrowing->due_date->format('d/m/Y')})",
            'action_url' => route('inventory.borrowing.show', $this->borrowing->id),
            'action_text' => 'ดูรายละเอียด',
            'borrowing_id' => $this->borrowing->id,
        ];
    }
}
