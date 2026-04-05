<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RequisitionRejected extends Notification
{
    use Queueable;

    public function __construct(public Requisition $requisition)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'requisition_rejected',
            'icon' => 'bi-x-circle',
            'color' => 'danger',
            'title' => 'ใบเบิกของคุณถูกปฏิเสธ',
            'message' => "ใบเบิกวันที่ {$this->requisition->req_date->format('d/m/Y')} ไม่ได้รับการอนุมัติ",
            'action_url' => route('inventory.requisition.show', $this->requisition->id),
            'action_text' => 'ดูรายละเอียด',
            'requisition_id' => $this->requisition->id,
        ];
    }
}
