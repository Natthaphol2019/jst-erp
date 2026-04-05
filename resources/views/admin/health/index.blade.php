@extends('layouts.app')

@section('title', 'ตรวจสอบสุขภาพระบบ - JST ERP')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-heartbeat me-2" style="color: #818cf8;"></i>ตรวจสอบสุขภาพระบบ
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">ตรวจสอบสถานะการทํางานของระบบทั้งหมด</p>
    </div>
</div>

{{-- Overall Status Alert --}}
@if ($allOk)
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>
        <strong style="color: var(--text-primary);">ระบบทํางานปกติ!</strong> รายการตรวจสอบทั้งหมดผ่าน
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
    </div>
@else
    <div class="erp-alert erp-alert-danger mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong style="color: var(--text-primary);">พบปัญหา!</strong> มีรายการตรวจสอบที่ล้มเหลว กรุณาตรวจสอบด้านล่าง
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
    </div>
@endif

<div class="row g-3">
    {{-- Database Connection --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['database']['status'] === 'ok' ? '#34d399' : '#f87171' }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-database me-2" style="color: {{ $checks['database']['status'] === 'ok' ? '#34d399' : '#f87171' }};"></i>
                    <span class="erp-card-title" style="margin: 0;">ฐานข้อมูล</span>
                    <span style="margin-left: auto;">
                        @if ($checks['database']['status'] === 'ok')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                        @else
                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;"><i class="fas fa-times"></i></span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['database']['message'] }}</p>
                @if (!empty($checks['database']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['database']['details'] as $key => $value)
                                <tr style="border-color: var(--border);">
                                    <td style="width: 40%; color: var(--text-muted); font-size: 12px;">{{ $key }}</td>
                                    <td style="color: var(--text-secondary); font-size: 13px;">{{ is_array($value) ? json_encode($value) : $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Disk Space --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['disk_space']['status'] === 'ok' ? '#34d399' : ($checks['disk_space']['status'] === 'warning' ? '#fbbf24' : '#f87171') }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-hdd me-2" style="color: {{ $checks['disk_space']['status'] === 'ok' ? '#34d399' : ($checks['disk_space']['status'] === 'warning' ? '#fbbf24' : '#f87171') }};"></i>
                    <span class="erp-card-title" style="margin: 0;">พื้นที่ดิสก์</span>
                    <span style="margin-left: auto;">
                        @if ($checks['disk_space']['status'] === 'ok')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                        @elseif ($checks['disk_space']['status'] === 'warning')
                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;"><i class="fas fa-exclamation-triangle"></i></span>
                        @else
                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;"><i class="fas fa-times"></i></span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['disk_space']['message'] }}</p>
                @if (!empty($checks['disk_space']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['disk_space']['details'] as $key => $value)
                                <tr style="border-color: var(--border);">
                                    <td style="width: 40%; color: var(--text-muted); font-size: 12px;">{{ $key }}</td>
                                    <td style="color: var(--text-secondary); font-size: 13px;">{{ $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- PHP Version --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['php_version']['status'] === 'ok' ? '#34d399' : '#f87171' }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-code me-2" style="color: {{ $checks['php_version']['status'] === 'ok' ? '#34d399' : '#f87171' }};"></i>
                    <span class="erp-card-title" style="margin: 0;">เวอร์ชัน PHP</span>
                    <span style="margin-left: auto;">
                        @if ($checks['php_version']['status'] === 'ok')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                        @else
                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;"><i class="fas fa-times"></i></span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['php_version']['message'] }}</p>
                @if (!empty($checks['php_version']['details']))
                    <p style="margin: 0 0 4px; color: var(--text-secondary); font-size: 13px;"><strong style="color: var(--text-primary);">เวอร์ชันปัจจุบัน:</strong> {{ $checks['php_version']['details']['current'] }}</p>
                    <p style="margin: 0 0 12px; color: var(--text-secondary); font-size: 13px;"><strong style="color: var(--text-primary);">เวอร์ชันที่ต้องการ:</strong> {{ $checks['php_version']['details']['required'] }}</p>
                    <h6 style="font-size: 13px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">ส่วนขยาย PHP ที่ต้องการ:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($checks['php_version']['details']['extensions'] as $ext => $loaded)
                            <span class="erp-badge" style="background: {{ $loaded ? 'rgba(52,211,153,0.12)' : 'rgba(239,68,68,0.12)' }}; color: {{ $loaded ? '#34d399' : '#f87171' }};">
                                {{ $ext }} {{ $loaded ? '<i class=&quot;fas fa-check&quot;></i>' : '<i class=&quot;fas fa-times&quot;></i>' }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Laravel Version --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid #34d399;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-box me-2" style="color: #34d399;"></i>
                    <span class="erp-card-title" style="margin: 0;">Laravel</span>
                    <span style="margin-left: auto;">
                        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['laravel_version']['message'] }}</p>
                @if (!empty($checks['laravel_version']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['laravel_version']['details'] as $key => $value)
                                <tr style="border-color: var(--border);">
                                    <td style="width: 40%; color: var(--text-muted); font-size: 12px;">{{ $key }}</td>
                                    <td style="color: var(--text-secondary); font-size: 13px;">{{ $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Cache Status --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['cache']['status'] === 'ok' ? '#34d399' : '#fbbf24' }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-bolt me-2" style="color: {{ $checks['cache']['status'] === 'ok' ? '#34d399' : '#fbbf24' }};"></i>
                    <span class="erp-card-title" style="margin: 0;">ระบบแคช</span>
                    <span style="margin-left: auto;">
                        @if ($checks['cache']['status'] === 'ok')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                        @else
                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;"><i class="fas fa-exclamation-triangle"></i></span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['cache']['message'] }}</p>
                @if (!empty($checks['cache']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['cache']['details'] as $key => $value)
                                <tr style="border-color: var(--border);">
                                    <td style="width: 40%; color: var(--text-muted); font-size: 12px;">{{ $key }}</td>
                                    <td style="color: var(--text-secondary); font-size: 13px;">{{ $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Storage Permissions --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['storage_permissions']['status'] === 'ok' ? '#34d399' : '#f87171' }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-folder-open me-2" style="color: {{ $checks['storage_permissions']['status'] === 'ok' ? '#34d399' : '#f87171' }};"></i>
                    <span class="erp-card-title" style="margin: 0;">สิทธิ์โฟลเดอร์</span>
                    <span style="margin-left: auto;">
                        @if ($checks['storage_permissions']['status'] === 'ok')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                        @else
                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;"><i class="fas fa-times"></i></span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['storage_permissions']['message'] }}</p>
                @if (!empty($checks['storage_permissions']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['storage_permissions']['details'] as $path => $status)
                                <tr style="border-color: var(--border);">
                                    <td style="width: 40%; color: var(--text-muted); font-size: 12px;"><code style="color: var(--text-secondary);">{{ $path }}</code></td>
                                    <td>
                                        @if (str_contains($status, 'เขียนได้'))
                                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">{{ $status }}</span>
                                        @else
                                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">{{ $status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Environment --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['environment']['status'] === 'ok' ? '#34d399' : ($checks['environment']['status'] === 'warning' ? '#fbbf24' : '#f87171') }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-cog me-2" style="color: {{ $checks['environment']['status'] === 'ok' ? '#34d399' : ($checks['environment']['status'] === 'warning' ? '#fbbf24' : '#f87171') }};"></i>
                    <span class="erp-card-title" style="margin: 0;">สภาพแวดล้อม</span>
                    <span style="margin-left: auto;">
                        @if ($checks['environment']['status'] === 'ok')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                        @elseif ($checks['environment']['status'] === 'warning')
                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;"><i class="fas fa-exclamation-triangle"></i></span>
                        @else
                            <span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;"><i class="fas fa-times"></i></span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['environment']['message'] }}</p>
                @if (!empty($checks['environment']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['environment']['details'] as $key => $value)
                                @if ($key === 'warnings' && is_array($value) && !empty($value))
                                    <tr style="border-color: var(--border);">
                                        <td colspan="2" style="color: #f87171; font-size: 13px;">
                                            <strong style="color: var(--text-primary);">คําเตือน:</strong>
                                            <ul style="margin: 4px 0 0; padding-left: 20px;">
                                                @foreach ($value as $w)
                                                    <li>{{ $w }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @elseif ($key !== 'warnings' || empty($value))
                                    <tr style="border-color: var(--border);">
                                        <td style="width: 40%; color: var(--text-muted); font-size: 12px;">{{ $key }}</td>
                                        <td style="color: var(--text-secondary); font-size: 13px;">{{ is_array($value) ? json_encode($value) : $value }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Session --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid #34d399;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shield-alt me-2" style="color: #34d399;"></i>
                    <span class="erp-card-title" style="margin: 0;">เซสชัน</span>
                    <span style="margin-left: auto;">
                        <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['session']['message'] }}</p>
                @if (!empty($checks['session']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['session']['details'] as $key => $value)
                                <tr style="border-color: var(--border);">
                                    <td style="width: 40%; color: var(--text-muted); font-size: 12px;">{{ $key }}</td>
                                    <td style="color: var(--text-secondary); font-size: 13px;">{{ $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Log File --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['log_file']['status'] === 'ok' ? '#34d399' : '#fbbf24' }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-alt me-2" style="color: {{ $checks['log_file']['status'] === 'ok' ? '#34d399' : '#fbbf24' }};"></i>
                    <span class="erp-card-title" style="margin: 0;">ไฟล์บันทึกข้อผิดพลาด</span>
                    <span style="margin-left: auto;">
                        @if ($checks['log_file']['status'] === 'ok')
                            <span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;"><i class="fas fa-check"></i></span>
                        @else
                            <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;"><i class="fas fa-exclamation-triangle"></i></span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                <p style="margin: 0 0 8px; color: var(--text-secondary);"><strong style="color: var(--text-primary);">สถานะ:</strong> {{ $checks['log_file']['message'] }}</p>
                @if (!empty($checks['log_file']['details']))
                    <table class="erp-table" style="border: none;">
                        <tbody>
                            @foreach ($checks['log_file']['details'] as $key => $value)
                                @if ($value)
                                    <tr style="border-color: var(--border);">
                                        <td style="width: 40%; color: var(--text-muted); font-size: 12px;">{{ $key }}</td>
                                        <td style="color: var(--text-secondary); font-size: 13px;">
                                            @if ($key === 'warning')
                                                <span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">{{ $value }}</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Errors --}}
    <div class="col-md-6">
        <div class="erp-card h-100">
            <div class="erp-card-header" style="border-bottom: 2px solid {{ $checks['recent_errors']['count'] > 0 ? '#fbbf24' : '#34d399' }};">
                <div class="d-flex align-items-center">
                    <i class="fas fa-bug me-2" style="color: {{ $checks['recent_errors']['count'] > 0 ? '#fbbf24' : '#34d399' }};"></i>
                    <span class="erp-card-title" style="margin: 0;">ข้อผิดพลาดล่าสุด</span>
                    <span style="margin-left: auto;">
                        <span class="erp-badge" style="background: var(--input-bg); color: var(--text-secondary);">
                            {{ $checks['recent_errors']['count'] }} รายการ
                        </span>
                    </span>
                </div>
            </div>
            <div class="erp-card-body">
                @if ($checks['recent_errors']['count'] > 0)
                    <p style="margin: 0 0 12px; color: var(--text-secondary); font-size: 13px;">พบข้อผิดพลาด <strong style="color: var(--text-primary);">{{ $checks['recent_errors']['count'] }}</strong> รายการในไฟล์ล็อก</p>
                    <div class="accordion" id="errorAccordion">
                        @foreach ($checks['recent_errors']['errors'] as $index => $error)
                            <div class="accordion-item" style="background: var(--bg-surface); border: 1px solid var(--border); margin-bottom: 8px; border-radius: 8px;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#errorCollapse{{ $index }}"
                                            aria-expanded="false"
                                            style="background: var(--bg-surface); color: var(--text-primary); font-size: 13px;">
                                        ข้อผิดพลาด #{{ $index + 1 }}
                                    </button>
                                </h2>
                                <div id="errorCollapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#errorAccordion">
                                    <div class="accordion-body" style="background: var(--bg-surface);">
                                        <pre style="background: var(--input-bg); padding: 12px; border-radius: 6px; max-height: 200px; overflow-y: auto; font-size: 0.8rem; color: var(--text-secondary);">{{ $error }}</pre>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="erp-empty">
                        <i class="fas fa-check-circle"></i>
                        <div>ไม่มีข้อผิดพลาดในระบบ</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
