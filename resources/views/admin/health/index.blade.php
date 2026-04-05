@extends('layouts.app')

@section('title', 'ตรวจสอบสุขภาพระบบ')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="bi bi-heart-pulse me-2"></i>ตรวจสอบสุขภาพระบบ</h2>
            <p class="text-muted">ตรวจสอบสถานะการทํางานของระบบทั้งหมด</p>
        </div>
    </div>

    {{-- Overall Status Alert --}}
    @if ($allOk)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>ระบบทํางานปกติ!</strong> รายการตรวจสอบทั้งหมดผ่าน
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @else
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>พบปัญหา!</strong> มีรายการตรวจสอบที่ล้มเหลว กรุณาตรวจสอบด้านล่าง
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Database Connection --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center {{ $checks['database']['status'] === 'ok' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                    <i class="bi bi-database me-2"></i>
                    <h5 class="mb-0">ฐานข้อมูล</h5>
                    <span class="ms-auto">
                        @if ($checks['database']['status'] === 'ok')
                            <i class="bi bi-check-circle-fill"></i>
                        @else
                            <i class="bi bi-x-circle-fill"></i>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['database']['message'] }}</p>
                    @if (!empty($checks['database']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['database']['details'] as $key => $value)
                                    <tr>
                                        <td class="text-muted" style="width: 40%;">{{ $key }}</td>
                                        <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- Disk Space --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center
                    {{ $checks['disk_space']['status'] === 'ok' ? 'bg-success text-white' : ($checks['disk_space']['status'] === 'warning' ? 'bg-warning text-dark' : 'bg-danger text-white') }}">
                    <i class="bi bi-hdd me-2"></i>
                    <h5 class="mb-0">พื้นที่ดิสก์</h5>
                    <span class="ms-auto">
                        @if ($checks['disk_space']['status'] === 'ok')
                            <i class="bi bi-check-circle-fill"></i>
                        @elseif ($checks['disk_space']['status'] === 'warning')
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        @else
                            <i class="bi bi-x-circle-fill"></i>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['disk_space']['message'] }}</p>
                    @if (!empty($checks['disk_space']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['disk_space']['details'] as $key => $value)
                                    <tr>
                                        <td class="text-muted" style="width: 40%;">{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- PHP Version --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center {{ $checks['php_version']['status'] === 'ok' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                    <i class="bi bi-filetype-php me-2"></i>
                    <h5 class="mb-0">เวอร์ชัน PHP</h5>
                    <span class="ms-auto">
                        @if ($checks['php_version']['status'] === 'ok')
                            <i class="bi bi-check-circle-fill"></i>
                        @else
                            <i class="bi bi-x-circle-fill"></i>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['php_version']['message'] }}</p>
                    @if (!empty($checks['php_version']['details']))
                        <p class="mb-1"><strong>เวอร์ชันปัจจุบัน:</strong> {{ $checks['php_version']['details']['current'] }}</p>
                        <p class="mb-2"><strong>เวอร์ชันที่ต้องการ:</strong> {{ $checks['php_version']['details']['required'] }}</p>
                        <h6 class="mb-2">ส่วนขยาย PHP ที่ต้องการ:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($checks['php_version']['details']['extensions'] as $ext => $loaded)
                                <span class="badge {{ $loaded ? 'bg-success' : 'bg-danger' }}">
                                    {{ $ext }} {{ $loaded ? '✓' : '✗' }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Laravel Version --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-box me-2"></i>
                    <h5 class="mb-0">Laravel</h5>
                    <span class="ms-auto"><i class="bi bi-check-circle-fill"></i></span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['laravel_version']['message'] }}</p>
                    @if (!empty($checks['laravel_version']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['laravel_version']['details'] as $key => $value)
                                    <tr>
                                        <td class="text-muted" style="width: 40%;">{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- Cache Status --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center {{ $checks['cache']['status'] === 'ok' ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                    <i class="bi bi-lightning me-2"></i>
                    <h5 class="mb-0">ระบบแคช</h5>
                    <span class="ms-auto">
                        @if ($checks['cache']['status'] === 'ok')
                            <i class="bi bi-check-circle-fill"></i>
                        @else
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['cache']['message'] }}</p>
                    @if (!empty($checks['cache']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['cache']['details'] as $key => $value)
                                    <tr>
                                        <td class="text-muted" style="width: 40%;">{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- Storage Permissions --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center {{ $checks['storage_permissions']['status'] === 'ok' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                    <i class="bi bi-folder2-open me-2"></i>
                    <h5 class="mb-0">สิทธิ์โฟลเดอร์</h5>
                    <span class="ms-auto">
                        @if ($checks['storage_permissions']['status'] === 'ok')
                            <i class="bi bi-check-circle-fill"></i>
                        @else
                            <i class="bi bi-x-circle-fill"></i>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['storage_permissions']['message'] }}</p>
                    @if (!empty($checks['storage_permissions']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['storage_permissions']['details'] as $path => $status)
                                    <tr>
                                        <td class="text-muted" style="width: 40%;"><code>{{ $path }}</code></td>
                                        <td>
                                            @if (str_contains($status, 'เขียนได้'))
                                                <span class="badge bg-success">{{ $status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $status }}</span>
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
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center
                    {{ $checks['environment']['status'] === 'ok' ? 'bg-success text-white' : ($checks['environment']['status'] === 'warning' ? 'bg-warning text-dark' : 'bg-danger text-white') }}">
                    <i class="bi bi-gear me-2"></i>
                    <h5 class="mb-0">สภาพแวดล้อม</h5>
                    <span class="ms-auto">
                        @if ($checks['environment']['status'] === 'ok')
                            <i class="bi bi-check-circle-fill"></i>
                        @elseif ($checks['environment']['status'] === 'warning')
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        @else
                            <i class="bi bi-x-circle-fill"></i>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['environment']['message'] }}</p>
                    @if (!empty($checks['environment']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['environment']['details'] as $key => $value)
                                    @if ($key === 'warnings' && is_array($value) && !empty($value))
                                        <tr>
                                            <td colspan="2" class="text-danger">
                                                <strong>คําเตือน:</strong>
                                                <ul class="mb-0 ps-3">
                                                    @foreach ($value as $w)
                                                        <li>{{ $w }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @elseif ($key !== 'warnings' || empty($value))
                                        <tr>
                                            <td class="text-muted" style="width: 40%;">{{ $key }}</td>
                                            <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
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
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-shield-lock me-2"></i>
                    <h5 class="mb-0">เซสชัน</h5>
                    <span class="ms-auto"><i class="bi bi-check-circle-fill"></i></span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['session']['message'] }}</p>
                    @if (!empty($checks['session']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['session']['details'] as $key => $value)
                                    <tr>
                                        <td class="text-muted" style="width: 40%;">{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- Log File --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center
                    {{ $checks['log_file']['status'] === 'ok' ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                    <i class="bi bi-journal-text me-2"></i>
                    <h5 class="mb-0">ไฟล์บันทึกข้อผิดพลาด</h5>
                    <span class="ms-auto">
                        @if ($checks['log_file']['status'] === 'ok')
                            <i class="bi bi-check-circle-fill"></i>
                        @else
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>สถานะ:</strong> {{ $checks['log_file']['message'] }}</p>
                    @if (!empty($checks['log_file']['details']))
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                @foreach ($checks['log_file']['details'] as $key => $value)
                                    @if ($value)
                                        <tr>
                                            <td class="text-muted" style="width: 40%;">{{ $key }}</td>
                                            <td>
                                                @if ($key === 'warning')
                                                    <span class="badge bg-warning">{{ $value }}</span>
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
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header {{ $checks['recent_errors']['count'] > 0 ? 'bg-warning text-dark' : 'bg-success text-white' }} d-flex align-items-center">
                    <i class="bi bi-bug me-2"></i>
                    <h5 class="mb-0">ข้อผิดพลาดล่าสุด</h5>
                    <span class="ms-auto badge bg-light text-dark">
                        {{ $checks['recent_errors']['count'] }} รายการ
                    </span>
                </div>
                <div class="card-body">
                    @if ($checks['recent_errors']['count'] > 0)
                        <p class="mb-2">พบข้อผิดพลาด <strong>{{ $checks['recent_errors']['count'] }}</strong> รายการในไฟล์ล็อก</p>
                        <div class="accordion" id="errorAccordion">
                            @foreach ($checks['recent_errors']['errors'] as $index => $error)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#errorCollapse{{ $index }}"
                                                aria-expanded="false">
                                            ข้อผิดพลาด #{{ $index + 1 }}
                                        </button>
                                    </h2>
                                    <div id="errorCollapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#errorAccordion">
                                        <div class="accordion-body">
                                            <pre class="bg-light p-2 rounded" style="max-height: 200px; overflow-y: auto; font-size: 0.8rem;">{{ $error }}</pre>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            <p class="mt-2 text-muted">ไม่มีข้อผิดพลาดในระบบ</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
