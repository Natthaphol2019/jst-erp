<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * แสดงรายการการแจ้งเตือนทั้งหมดของผู้ใช้
     */
    public function index(Request $request)
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = auth()->user()->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * ทำเครื่องหมายว่าอ่านแล้ว (รายการเดียว)
     */
    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Clear cache
        $userId = auth()->id();
        cache()->forget("unread_count_{$userId}");
        cache()->forget("recent_notifications_{$userId}");

        // ถ้ามีการส่ง action_url กลับไปหน้าที่เกี่ยวข้อง
        $actionUrl = $notification->data['action_url'] ?? route('notifications.index');

        return redirect($actionUrl)->with('success', 'อ่านการแจ้งเตือนแล้ว');
    }

    /**
     * ทำเครื่องหมายว่าอ่านแล้วทั้งหมด
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        // Clear cache
        $userId = auth()->id();
        cache()->forget("unread_count_{$userId}");
        cache()->forget("recent_notifications_{$userId}");

        return redirect()->back()->with('success', 'อ่านการแจ้งเตือนทั้งหมดแล้ว');
    }

    /**
     * ส่งจำนวนการแจ้งเตือนที่ยังไม่อ่าน (สำหรับ AJAX)
     */
    public function unreadCount()
    {
        $count = auth()->user()->unreadNotifications()->count();

        return response()->json(['count' => $count]);
    }
}
