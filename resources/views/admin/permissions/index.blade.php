@extends('layouts.app')

@section('title', 'ตั้งค่าสิทธิ์การใช้งาน - JST ERP')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-key me-2" style="color: #818cf8;"></i>ตั้งค่าสิทธิ์การใช้งาน (Access Rights)
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">กำหนดสิทธิ์การเข้าถึงเมนูและฟังก์ชันในแต่ละ Role (Odoo-style)</p>
    </div>
</div>

@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4" id="successAlert" style="position: relative; padding-right: 40px;">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" onclick="this.parentElement.remove()" style="position: absolute; top: 8px; right: 12px; background: none; border: none; color: inherit; cursor: pointer; font-size: 16px;">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="erp-alert erp-alert-danger mb-4" id="errorAlert" style="position: relative; padding-right: 40px;">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" onclick="this.parentElement.remove()" style="position: absolute; top: 8px; right: 12px; background: none; border: none; color: inherit; cursor: pointer; font-size: 16px;">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

{{-- Toast Notification --}}
<div id="saveToast" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999; display: none;">
    <div class="toast show" role="alert" style="background: var(--bg-surface); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.2);">
        <div class="toast-header" style="background: var(--bg-raised); border-bottom: 1px solid var(--border);">
            <i class="fas fa-check-circle me-2" style="color: #34d399; font-size: 16px;"></i>
            <strong class="me-auto" style="color: var(--text-primary);">บันทึกสำเร็จ</strong>
            <small style="color: var(--text-muted);">เมื่อสักครู่</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" onclick="hideToast()"></button>
        </div>
        <div class="toast-body" style="color: var(--text-secondary);">
            <span id="toastMessage">บันทึกสิทธิ์เรียบร้อยแล้ว</span>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- ==================== LEFT: Role Selector ==================== --}}
    <div class="col-md-3">
        <div class="erp-card">
            <div class="erp-card-header">
                <span class="erp-card-title">
                    <i class="fas fa-user-tag me-2" style="color: #6366f1;"></i>เลือก Role
                </span>
            </div>
            <div class="erp-card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($roles as $r)
                        @if($r === 'admin')
                            <div class="list-group-item px-3 py-2 {{ $selectedRole === $r ? 'bg-primary bg-opacity-10' : '' }}"
                                 style="opacity: 0.6; cursor: default;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-shield-alt" style="color: #f87171;"></i>
                                    <div class="flex-grow-1">
                                        <strong>{{ $roleLabels[$r] }}</strong>
                                        <div style="font-size: 11px; color: var(--text-muted);">ทุกสิทธิ์ (ไม่สามารถแก้ไข)</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('admin.permissions.index', ['role' => $r]) }}"
                               class="list-group-item list-group-item-action px-3 py-2 {{ $selectedRole === $r ? 'bg-primary bg-opacity-10 border-primary' : '' }}">
                                <div class="d-flex align-items-center gap-2">
                                    @if($r === 'hr')
                                        <i class="fas fa-users" style="color: #38bdf8;"></i>
                                    @elseif($r === 'manager')
                                        <i class="fas fa-user-tie" style="color: #fbbf24;"></i>
                                    @elseif($r === 'inventory')
                                        <i class="fas fa-warehouse" style="color: #34d399;"></i>
                                    @elseif($r === 'employee')
                                        <i class="fas fa-user" style="color: #9ca3af;"></i>
                                    @endif
                                    <div class="flex-grow-1">
                                        <strong>{{ $roleLabels[$r] }}</strong>
                                        <div style="font-size: 11px; color: var(--text-muted);">
                                            {{ $userCounts[$r] ?? 0 }} คน
                                        </div>
                                    </div>
                                    @if($selectedRole === $r)
                                        <i class="fas fa-chevron-right" style="color: var(--accent);"></i>
                                    @endif
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Info --}}
        <div class="erp-card mt-3">
            <div class="erp-card-body">
                <h6 style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">
                    <i class="fas fa-info-circle me-1"></i>คำแนะนำ
                </h6>
                <ul style="font-size: 11px; color: var(--text-secondary); padding-left: 16px; margin: 0;">
                    <li>เลือก Role ทางซ้ายเพื่อตั้งค่าสิทธิ์</li>
                    <li>ติ๊กถูก/ไม่ถูก ตามสิทธิ์ที่ต้องการ</li>
                    <li>กด "บันทึกการตั้งค่า" เพื่อบันทึก</li>
                    <li>Admin มีทุกสิทธิ์อยู่แล้ว</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ==================== RIGHT: Permission Settings ==================== --}}
    <div class="col-md-9">
        <form action="{{ route('admin.permissions.update') }}" method="POST" id="permissionForm">
            @csrf
            <input type="hidden" name="role" value="{{ $selectedRole }}">

            @if($selectedRole === 'admin')
                <div class="erp-card">
                    <div class="erp-card-body text-center py-5">
                        <i class="fas fa-shield-alt mb-3" style="font-size: 48px; color: #f87171;"></i>
                        <h5 style="color: var(--text-primary);">Admin มีทุกสิทธิ์อยู่แล้ว</h5>
                        <p style="color: var(--text-muted);">ไม่ต้องตั้งค่าสิทธิ์สำหรับ Admin</p>
                    </div>
                </div>
            @else
                {{-- Header Actions --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin: 0;">
                            <i class="fas fa-cog me-2" style="color: #818cf8;"></i>ตั้งค่าสิทธิ์: {{ $roleLabels[$selectedRole] }}
                        </h5>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="erp-btn-secondary" onclick="checkAll(true)">
                            <i class="fas fa-check-double me-1"></i>เลือกทั้งหมด
                        </button>
                        <button type="button" class="erp-btn-secondary" onclick="checkAll(false)">
                            <i class="fas fa-times me-1"></i>ล้างทั้งหมด
                        </button>
                        <a href="{{ route('admin.permissions.index', ['role' => $selectedRole]) }}" class="erp-btn-secondary">
                            <i class="fas fa-undo me-1"></i>รีเฟรช
                        </a>
                        <form action="{{ route('admin.permissions.reset') }}" method="POST" class="d-inline"
                              onsubmit="return confirm('ต้องการรีเซ็ตสิทธิ์ของ {{ $roleLabels[$selectedRole] }} กลับไปค่าเริ่มต้น ใช่หรือไม่?')">
                            @csrf
                            <input type="hidden" name="role" value="{{ $selectedRole }}">
                            <button type="submit" class="erp-btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fas fa-rotate-left me-1"></i>รีเซ็ตค่าเริ่มต้น
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Permission Cards --}}
                <div class="accordion" id="permissionAccordion">
                @foreach($modules as $moduleKey => $perms)
                    @php
                        $moduleName = $perms->first()->module_name;
                        $moduleIcon = $perms->first()->module_icon ?? 'fas fa-circle';
                        $accordionId = 'collapse-' . str_replace('.', '-', $moduleKey);
                    @endphp
                    <div class="erp-card mb-2">
                        <div class="erp-card-header d-flex justify-content-between align-items-center" 
                             style="cursor: pointer; padding: 10px 16px; background: var(--bg-raised);"
                             data-bs-toggle="collapse" 
                             data-bs-target="#{{ $accordionId }}"
                             aria-expanded="false"
                             aria-controls="{{ $accordionId }}">
                            <span class="erp-card-title" style="margin: 0;">
                                <i class="{{ $moduleIcon }} me-2" style="color: #818cf8;"></i>{{ $moduleName }}
                            </span>
                            <div class="d-flex gap-2" onclick="event.stopPropagation()">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="checkModule('{{ $moduleKey }}', true)" title="เลือกทั้งหมดในหมวดนี้">
                                    <i class="fas fa-check-double me-1"></i>ทั้งหมด
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="checkModule('{{ $moduleKey }}', false)" title="ล้างทั้งหมดในหมวดนี้">
                                    <i class="fas fa-times me-1"></i>ล้าง
                                </button>
                                <i class="fas fa-chevron-down text-muted" style="font-size: 12px; transition: transform 0.2s;" id="icon-{{ $accordionId }}"></i>
                            </div>
                        </div>
                        <div id="{{ $accordionId }}" class="collapse" data-bs-parent="#permissionAccordion">
                            <div class="erp-card-body p-0">
                                <table class="perm-table mb-0" style="width: 100%;">
                                    <thead style="background: var(--bg-raised);">
                                        <tr>
                                            <th class="perm-name-col" style="padding: 8px 12px; font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                                รายการ
                                            </th>
                                            <th style="width: 50px; text-align: center; padding: 8px 4px; font-size: 11px; font-weight: 600; color: var(--text-muted);">ดู</th>
                                            <th style="width: 55px; text-align: center; padding: 8px 4px; font-size: 11px; font-weight: 600; color: var(--text-muted);">สร้าง</th>
                                            <th style="width: 55px; text-align: center; padding: 8px 4px; font-size: 11px; font-weight: 600; color: var(--text-muted);">แก้ไข</th>
                                            <th style="width: 50px; text-align: center; padding: 8px 4px; font-size: 11px; font-weight: 600; color: var(--text-muted);">ลบ</th>
                                            <th style="width: 60px; text-align: center; padding: 8px 4px; font-size: 11px; font-weight: 600; color: var(--text-muted);">Export</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($perms as $perm)
                                            @php
                                                $rp = $rolePermData->get($perm->id);
                                                $canView = $rp ? $rp->can_view : false;
                                                $canCreate = $rp ? $rp->can_create : false;
                                                $canEdit = $rp ? $rp->can_edit : false;
                                                $canDelete = $rp ? $rp->can_delete : false;
                                                $canExport = $rp ? $rp->can_export : false;
                                            @endphp
                                            <tr class="perm-row" style="border-bottom: 1px solid var(--border);">
                                                <td class="perm-name-col" style="padding: 10px 12px; font-size: 12px; color: var(--text-primary); font-weight: 500;">
                                                    {{ $perm->permission_name }}
                                                </td>
                                                <td style="text-align: center; padding: 8px 4px;">
                                                    <input type="hidden" name="permissions[{{ $perm->id }}][permission_id]" value="{{ $perm->id }}">
                                                    <input type="checkbox" name="permissions[{{ $perm->id }}][can_view]" value="1"
                                                           {{ $canView ? 'checked' : '' }}
                                                           class="perm-checkbox"
                                                           data-id="{{ $perm->id }}"
                                                           data-action="view"
                                                           onchange="autoCheckCreate(this)">
                                                </td>
                                                <td style="text-align: center; padding: 8px 4px;">
                                                    <input type="checkbox" name="permissions[{{ $perm->id }}][can_create]" value="1"
                                                           {{ $canCreate ? 'checked' : '' }}
                                                           class="perm-checkbox"
                                                           data-id="{{ $perm->id }}"
                                                           data-action="create">
                                                </td>
                                                <td style="text-align: center; padding: 8px 4px;">
                                                    <input type="checkbox" name="permissions[{{ $perm->id }}][can_edit]" value="1"
                                                           {{ $canEdit ? 'checked' : '' }}
                                                           class="perm-checkbox"
                                                           data-id="{{ $perm->id }}"
                                                           data-action="edit">
                                                </td>
                                                <td style="text-align: center; padding: 8px 4px;">
                                                    <input type="checkbox" name="permissions[{{ $perm->id }}][can_delete]" value="1"
                                                           {{ $canDelete ? 'checked' : '' }}
                                                           class="perm-checkbox"
                                                           data-id="{{ $perm->id }}"
                                                           data-action="delete">
                                                </td>
                                                <td style="text-align: center; padding: 8px 4px;">
                                                    <input type="checkbox" name="permissions[{{ $perm->id }}][can_export]" value="1"
                                                           {{ $canExport ? 'checked' : '' }}
                                                           class="perm-checkbox"
                                                           data-id="{{ $perm->id }}"
                                                           data-action="export">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>

                {{-- Save Button --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.permissions.index', ['role' => 'hr']) }}" class="erp-btn-secondary">
                        <i class="fas fa-times me-2"></i>ยกเลิก
                    </a>
                    <button type="submit" class="erp-btn-primary" style="padding: 10px 24px;">
                        <i class="fas fa-save me-2"></i>บันทึกการตั้งค่า
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>

@endsection

@push('scripts')
<style>
/* Permission table dark mode styles */
.perm-table {
    background: transparent !important;
}
.perm-table thead {
    background: var(--bg-raised) !important;
}
.perm-table th,
.perm-table td {
    background: transparent !important;
    border-color: var(--border) !important;
    color: inherit;
}
.perm-row:hover {
    background: rgba(99, 102, 241, 0.05) !important;
}
.perm-name-col {
    color: var(--text-primary) !important;
}

/* Checkbox styling for dark mode */
.perm-checkbox {
    width: 16px;
    height: 16px;
    margin: 0;
    cursor: pointer;
    accent-color: var(--accent);
}

/* Sticky header for long lists */
.perm-table thead tr th {
    position: sticky;
    top: 0;
    z-index: 10;
}
</style>

<script>
// ถ้าติ๊ก "ดู" ให้ติ๊ก "สร้าง" "แก้ไข" ด้วย
function autoCheckCreate(viewCheckbox) {
    const permId = viewCheckbox.dataset.id;
    const form = document.getElementById('permissionForm');
    
    if (viewCheckbox.checked) {
        const createCheckbox = form.querySelector(`.perm-checkbox[data-id="${permId}"][data-action="create"]`);
        const editCheckbox = form.querySelector(`.perm-checkbox[data-id="${permId}"][data-action="edit"]`);
        
        if (createCheckbox) createCheckbox.checked = true;
        if (editCheckbox) editCheckbox.checked = true;
    }
}

// เลือก/ล้าง ทั้งหมดใน module
function checkModule(moduleKey, checked) {
    const cards = document.querySelectorAll('.erp-card');
    cards.forEach(card => {
        const header = card.querySelector('.erp-card-header');
        if (header && header.textContent.includes(moduleKey)) {
            card.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                if (cb.name.includes('can_')) {
                    cb.checked = checked;
                }
            });
        }
    });
}

// เลือก/ล้าง ทุกอย่าง
function checkAll(checked) {
    document.querySelectorAll('input[type="checkbox"][name*="can_"]').forEach(cb => {
        cb.checked = checked;
    });
}

// Rotate chevron icon on collapse/expand
document.addEventListener('DOMContentLoaded', function() {
    const collapses = document.querySelectorAll('[data-bs-toggle="collapse"]');
    collapses.forEach(trigger => {
        const targetId = trigger.getAttribute('data-bs-target');
        const icon = trigger.querySelector('.fa-chevron-down');
        
        trigger.addEventListener('click', function() {
            const isCollapsed = document.querySelector(targetId).classList.contains('show');
            if (icon) {
                icon.style.transform = isCollapsed ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        });
    });

    // Show toast notification if success message exists
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        showToast(successAlert.textContent.trim());
        
        // Auto-hide alert after 5 seconds
        setTimeout(() => {
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.3s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 300);
            }
        }, 5000);
    }
});

// Toast notification
function showToast(message) {
    const toast = document.getElementById('saveToast');
    const toastMsg = document.getElementById('toastMessage');
    
    if (toast && toastMsg) {
        toastMsg.textContent = message;
        toast.style.display = 'block';
        
        // Auto-hide after 4 seconds
        setTimeout(() => {
            hideToast();
        }, 4000);
    }
}

function hideToast() {
    const toast = document.getElementById('saveToast');
    if (toast) {
        toast.style.display = 'none';
    }
}

// Scroll to top on form submission
document.getElementById('permissionForm')?.addEventListener('submit', function() {
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังบันทึก...';
    }
    
    // Scroll to top so user can see success message
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>
@endpush
