<?php

namespace App\Notifications;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RequisitionSubmitted extends Notification
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
        $requester = $this->requisition->employee;
        $name = $requester ? "{$requester->firstname} {$requester->lastname}" : 'ไม่ระบุ';

        return [
            'type' => 'requisition_submitted',
            'icon' => 'bi-file-earmark-text',
            'color' => 'primary',
            'title' => 'มีใบเบิกใหม่รออนุมัติ',
            'message' => "{$name} ได้ยื่นใบเบิกวันที่ {$this->requisition->req_date->format('d/m/Y')}",
            'action_url' => route('inventory.requisition.approve', $this->requisition->id),
            'action_text' => 'ตรวจสอบใบเบิก',
            'requisition_id' => $this->requisition->id,
        ];
    }
}
