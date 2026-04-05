@extends('layouts.app')

@section('title', 'การแจ้งเตือน - JST ERP')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4><i class="bi bi-bell me-2"></i>การแจ้งเตือน</h4>
                @if($unreadCount > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-all me-1"></i> อ่านทั้งหมด ({{ $unreadCount }})
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isRead = $notification->read_at !== null;
                            $color = $data['color'] ?? 'primary';
                            $icon = $data['icon'] ?? 'bi-bell';
                        @endphp
                        <div class="notification-item p-3 border-bottom {{ $isRead ? '' : 'bg-light' }}" style="{{ $isRead ? '' : 'border-left: 4px solid ' . ($data['color'] ?? '#0d6efd') . ';' }}">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="bg-{{ $color }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="{{ $icon }} text-{{ $color }} fs-5"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center mb-1">
                                        <h6 class="mb-0 me-2 {{ $isRead ? 'text-muted' : 'fw-bold' }}">
                                            {{ $data['title'] ?? 'การแจ้งเตือน' }}
                                        </h6>
                                        @if(!$isRead)
                                            <span class="badge bg-{{ $color }}">ใหม่</span>
                                        @endif
                                    </div>
                                    <p class="text-muted mb-1">{{ $data['message'] ?? '' }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $notification->created_at->format('d/m/Y H:i') }}
                                        ({{ $notification->created_at->diffForHumans() }})
                                    </small>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex gap-2">
                                        @if(isset($data['action_url']))
                                            @if(!$isRead)
                                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-{{ $color }}" title="อ่านและเปิดดู">
                                                        <i class="bi bi-box-arrow-up-right"></i> {{ $data['action_text'] ?? 'ดู' }}
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ $data['action_url'] }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye"></i> ดู
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-bell-slash" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">ไม่มีการแจ้งเตือน</h5>
                            <p>คุณจะได้รับการแจ้งเตือนเมื่อมีเหตุการณ์สำคัญในระบบ</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .notification-item:hover {
        background-color: #f8f9fa !important;
    }
    .notification-item:not(.bg-light) {
        border-left: 4px solid #dee2e6;
    }
</style>
@endpush
