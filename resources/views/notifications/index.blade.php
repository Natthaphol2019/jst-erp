@extends('layouts.app')

@section('title', 'การแจ้งเตือน - JST ERP')

@section('content')

{{-- 1. Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-bell me-2" style="color: #818cf8;"></i>การแจ้งเตือน
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
            @if($unreadCount > 0)
                มี {{ $unreadCount }} การแจ้งเตือนที่ยังไม่อ่าน
            @else
                การแจ้งเตือนทั้งหมดอ่านแล้ว
            @endif
        </p>
    </div>
    @if($unreadCount > 0)
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="erp-btn-primary">
                <i class="fas fa-check-double me-2"></i>อ่านทั้งหมด ({{ $unreadCount }})
            </button>
        </form>
    @endif
</div>

{{-- Flash messages --}}
@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="row g-3">
    <div class="col-12">
        <div class="erp-card">
            <div class="erp-card-body" style="padding: 0;">
                @forelse($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $isRead = $notification->read_at !== null;
                        $color = $data['color'] ?? 'primary';
                        $icon = match($color) {
                            'success' => 'fas fa-check-circle',
                            'warning' => 'fas fa-exclamation-triangle',
                            'danger' => 'fas fa-times-circle',
                            'info' => 'fas fa-info-circle',
                            default => 'fas fa-bell',
                        };
                    @endphp
                    <div class="notification-item p-3"
                         style="border-bottom: 1px solid var(--border); {{ $isRead ? '' : 'border-left: 4px solid ' . ($data['color'] ?? '#6366f1') . '; background: var(--input-bg);' }}">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px; background: rgba(99,102,241,0.12);">
                                    <i class="{{ $icon }}" style="font-size: 1.25rem; color: #818cf8;"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="mb-0 me-2" style="font-size: 14px; font-weight: {{ $isRead ? '400' : '600' }}; color: var(--text-primary);">
                                        {{ $data['title'] ?? 'การแจ้งเตือน' }}
                                    </h6>
                                    @if(!$isRead)
                                        <span class="erp-badge" style="background: rgba(99,102,241,0.12); color: #818cf8; font-size: 11px; padding: 2px 8px;">
                                            ใหม่
                                        </span>
                                    @endif
                                </div>
                                <p style="font-size: 13px; color: var(--text-secondary); margin: 0 0 4px;">{{ $data['message'] ?? '' }}</p>
                                <small style="font-size: 11px; color: var(--text-muted);">
                                    <i class="fas fa-clock me-1"></i>{{ $notification->created_at->format('d/m/Y H:i') }}
                                    ({{ $notification->created_at->diffForHumans() }})
                                </small>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex gap-2">
                                    @if(isset($data['action_url']))
                                        @php
                                            // แปลง URL จาก /approve เป็นหน้า show (ทุกคนเข้าได้)
                                            $displayUrl = str_replace('/approve', '', $data['action_url']);
                                        @endphp
                                        @if(!$isRead)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="redirect_url" value="{{ $displayUrl }}">
                                                <button type="submit" class="erp-btn-secondary" style="padding: 4px 12px; font-size: 12px;" title="อ่านและเปิดดู">
                                                    <i class="fas fa-external-link-alt me-1"></i> {{ $data['action_text'] ?? 'ดู' }}
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ $displayUrl }}" class="erp-btn-secondary" style="padding: 4px 12px; font-size: 12px;">
                                                <i class="fas fa-eye me-1"></i> ดู
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="erp-empty">
                        <i class="fas fa-bell-slash"></i>
                        <div>ไม่มีการแจ้งเตือน</div>
                        <p style="font-size: 13px; color: var(--text-muted); margin-top: 8px;">คุณจะได้รับการแจ้งเตือนเมื่อมีเหตุการณ์สำคัญในระบบ</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border);">
                <div class="d-flex justify-content-between align-items-center">
                    <div style="font-size: 13px; color: var(--text-secondary);">
                        แสดง <strong style="color: var(--text-primary);">{{ $notifications->firstItem() }}</strong> ถึง <strong style="color: var(--text-primary);">{{ $notifications->lastItem() }}</strong> จาก <strong style="color: var(--text-primary);">{{ $notifications->total() }}</strong> รายการ
                    </div>
                    {{ $notifications->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    .notification-item:hover {
        background-color: var(--input-bg) !important;
    }
    .notification-item:not([style*="border-left"]) {
        border-left: 4px solid var(--border);
    }
</style>
@endpush
