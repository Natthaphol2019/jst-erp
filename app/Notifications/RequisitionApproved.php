<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RequisitionApproved extends Notification
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
            'type' => 'requisition_approved',
            'icon' => 'bi-check-circle',
            'color' => 'success',
            'title' => 'ใบเบิกของคุณได้รับการอนุมัติแล้ว',
            'message' => "ใบเบิกวันที่ {$this->requisition->req_date->format('d/m/Y')} ได้รับการอนุมัติเรียบร้อยแล้ว",
            'action_url' => route('inventory.requisition.show', $this->requisition->id),
            'action_text' => 'ดูรายละเอียด',
            'requisition_id' => $this->requisition->id,
        ];
    }
}
