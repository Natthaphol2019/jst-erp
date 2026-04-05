{{-- Mobile Toggle Button --}}
<button id="mobile-sidebar-toggle"
    class="btn d-md-none position-fixed d-flex align-items-center justify-content-center"
    style="bottom: 24px; right: 24px; z-index: 1060; border-radius: 50%; width: 52px; height: 52px;
           background: #6366f1; color: white; border: none; box-shadow: 0 4px 20px rgba(99,102,241,0.45);">
    <i class="fas fa-bars fs-5"></i>
</button>

<div id="main-sidebar" class="sidebar d-flex flex-column"
     style="width: 240px; min-height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            z-index: 1050; flex-shrink: 0;">

    {{-- Logo / Brand --}}
    <div class="d-flex justify-content-between align-items-center px-3 border-bottom"
         style="height: 58px; border-color: var(--sidebar-border) !important;">
        <h5 class="m-0 fw-semibold sidebar-text text-truncate d-flex align-items-center gap-2"
            style="color: var(--text-primary); font-size: 14px;">
            <span class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                  style="width: 32px; height: 32px; background: linear-gradient(135deg, #3b82f6, #6366f1); font-size: 16px;">🏭</span>
            <span>JST Industry</span>
        </h5>
        <button id="toggle-sidebar" class="border-0 d-none d-md-flex align-items-center justify-content-center p-0"
                style="width: 30px; height: 30px; border-radius: 8px; background: var(--input-bg); color: var(--text-secondary); transition: all 0.15s;">
            <i class="fas fa-align-right" style="font-size: 13px;"></i>
        </button>
        <button id="close-sidebar-mobile" class="border-0 d-md-none"
                style="color: var(--text-secondary);">
            <i class="fas fa-times"></i>
        </button>
    </div>

    @php
        $dashRoute = match (auth()->user()->role) {
            'admin'     => route('admin.dashboard'),
            'manager'   => route('manager.dashboard'),
            'employee'  => route('employee.dashboard'),
            'hr'        => route('hr.dashboard'),
            'inventory' => route('inventory.dashboard'),
            default     => url('/'),
        };
    @endphp

    <div class="flex-grow-1 overflow-auto pb-3 custom-scrollbar">
        <ul class="nav flex-column mt-2 mb-auto">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ $dashRoute }}"
                    class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('*dashboard') ? 'sb-active' : '' }}">
                    <i class="fas fa-tachometer-alt sb-icon"></i>
                    <span class="sidebar-text">แดชบอร์ด</span>
                </a>
            </li>

            @if (in_array(auth()->user()->role, ['admin', 'hr']))
                <li class="nav-item mt-3 mb-1 px-3 sidebar-text">
                    <span class="sb-section-label">ระบบบุคลากร (HR)</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.employees.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('hr.employees.*') ? 'sb-active' : '' }}">
                        <i class="fas fa-users sb-icon"></i>
                        <span class="sidebar-text">จัดการพนักงาน</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.departments.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('hr.departments.*') ? 'sb-active' : '' }}">
                        <i class="fas fa-sitemap sb-icon"></i>
                        <span class="sidebar-text">จัดการแผนก</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.positions.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('hr.positions.*') ? 'sb-active' : '' }}">
                        <i class="fas fa-briefcase sb-icon"></i>
                        <span class="sidebar-text">จัดการตำแหน่ง</span>
                    </a>
                </li>

                <li class="nav-item mt-3 mb-1 px-3 sidebar-text">
                    <span class="sb-section-label">ระบบลงเวลา (Time)</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.time-records.batch.select') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('hr.time-records.batch.*') ? 'sb-active' : '' }}">
                        <i class="fas fa-clock sb-icon"></i>
                        <span class="sidebar-text">บันทึกเวลาจากบัตร</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.time-records.summary') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('hr.time-records.summary') ? 'sb-active' : '' }}">
                        <i class="fas fa-chart-line sb-icon"></i>
                        <span class="sidebar-text">รายงานสรุปรายเดือน</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.time-records.lock') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('hr.time-records.lock*') ? 'sb-active-danger' : '' }}"
                        style="color: rgba(239,68,68,0.7);">
                        <i class="fas fa-lock sb-icon"></i>
                        <span class="sidebar-text">ปิดงวดเวลาทำงาน</span>
                    </a>
                </li>
            @endif

            @if (in_array(auth()->user()->role, ['admin', 'inventory']))
                <li class="nav-item mt-3 mb-1 px-3 sidebar-text">
                    <span class="sb-section-label">ระบบคลังสินค้า</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.items.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('inventory.items.*') ? 'sb-active' : '' }}">
                        <i class="fas fa-box-open sb-icon"></i>
                        <span class="sidebar-text">รายการสินค้า/อุปกรณ์</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.categories.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('inventory.categories.*') ? 'sb-active' : '' }}">
                        <i class="fas fa-tags sb-icon"></i>
                        <span class="sidebar-text">จัดการหมวดหมู่</span>
                    </a>
                </li>

                <li class="nav-item mt-3 mb-1 px-3 sidebar-text">
                    <span class="sb-section-label">ระบบยืม-คืน</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.borrowing.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ (request()->routeIs('inventory.borrowing.*') && !request()->routeIs('inventory.borrowing.create')) ? 'sb-active' : '' }}">
                        <i class="fas fa-hand-holding sb-icon"></i>
                        <span class="sidebar-text">รายการยืมทั้งหมด</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.borrowing.create') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('inventory.borrowing.create') ? 'sb-active' : '' }}">
                        <i class="fas fa-plus-circle sb-icon"></i>
                        <span class="sidebar-text">สร้างใบยืมใหม่</span>
                    </a>
                </li>

                <li class="nav-item mt-3 mb-1 px-3 sidebar-text">
                    <span class="sb-section-label">ระบบเบิกของ</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.requisition.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ (request()->routeIs('inventory.requisition.*') && !request()->routeIs('inventory.requisition.create')) ? 'sb-active' : '' }}">
                        <i class="fas fa-file-alt sb-icon"></i>
                        <span class="sidebar-text">รายการเบิกทั้งหมด</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.requisition.create') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('inventory.requisition.create') ? 'sb-active' : '' }}">
                        <i class="fas fa-plus-circle sb-icon"></i>
                        <span class="sidebar-text">สร้างใบเบิกใหม่</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->role === 'admin')
                <li class="nav-item mt-3 mb-1 px-3 sidebar-text">
                    <span class="sb-section-label">ระบบจัดการผู้ใช้</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.activity-logs.index') }}"
                        class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-2 rounded-2 {{ request()->routeIs('admin.activity-logs.*') ? 'sb-active' : '' }}">
                        <i class="fas fa-clipboard-list sb-icon"></i>
                        <span class="sidebar-text">บันทึกกิจกรรม</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>

    {{-- Bottom nav --}}
    <div style="border-top: 1px solid var(--sidebar-border); padding: 8px 0 12px;">
        <ul class="nav flex-column">
            @php
                $sidebarUnreadCount = auth()->user()->unreadNotifications()->count();
            @endphp
            <li class="nav-item">
                <a href="{{ route('notifications.index') }}"
                    class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-1 rounded-2 {{ request()->routeIs('notifications.*') ? 'sb-active' : '' }}">
                    <div class="position-relative" style="width: 18px; text-align: center;">
                        <i class="fas fa-bell sb-icon"></i>
                        @if($sidebarUnreadCount > 0)
                            <span class="position-absolute bg-danger rounded-circle"
                                  style="width: 6px; height: 6px; top: -2px; right: -2px;"></span>
                        @endif
                    </div>
                    <span class="sidebar-text d-flex align-items-center justify-content-between w-100">
                        การแจ้งเตือน
                        @if($sidebarUnreadCount > 0)
                            <span class="badge rounded-pill" style="background: rgba(239,68,68,0.15); color: #f87171; font-size: 10px;">
                                {{ $sidebarUnreadCount > 99 ? '99+' : $sidebarUnreadCount }}
                            </span>
                        @endif
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}"
                    class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-1 rounded-2 {{ request()->routeIs('profile.edit') ? 'sb-active' : '' }}">
                    <i class="fas fa-user-edit sb-icon"></i>
                    <span class="sidebar-text">แก้ไขข้อมูลส่วนตัว</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.change-password') }}"
                    class="sidebar-link nav-link d-flex align-items-center gap-2 px-3 py-2 mx-1 rounded-2 {{ request()->routeIs('profile.change-password') ? 'sb-active' : '' }}">
                    <i class="fas fa-key sb-icon"></i>
                    <span class="sidebar-text">เปลี่ยนรหัสผ่าน</span>
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="sidebar-link btn btn-link w-100 text-start d-flex align-items-center gap-2 px-3 py-2 mx-1 rounded-2 text-decoration-none border-0"
                        style="color: rgba(239,68,68,0.7);">
                        <i class="fas fa-sign-out-alt sb-icon"></i>
                        <span class="sidebar-text">ออกจากระบบ</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<style>
    #main-sidebar {
        transition: width 0.28s cubic-bezier(0.25, 0.8, 0.25, 1),
                    background-color 0.22s ease,
                    border-color 0.22s ease;
    }

    .sb-section-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--sb-section-color);
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .sb-icon {
        width: 18px;
        text-align: center;
        flex-shrink: 0;
        font-size: 13px;
        color: inherit;
    }

    .sidebar-link {
        color: var(--sb-link-color) !important;
        transition: all 0.15s ease;
        border-radius: 8px !important;
    }
    .sidebar-link:hover {
        background-color: var(--sb-hover-bg) !important;
        color: var(--sb-hover-color) !important;
        transform: translateX(2px);
    }

    .sb-active {
        background-color: var(--sb-active-bg) !important;
        color: #818cf8 !important;
        border-left: 2px solid #6366f1;
        padding-left: 10px !important;
    }
    .sb-active .sb-icon { color: #818cf8 !important; }

    .sb-active-danger {
        background-color: rgba(239,68,68,0.1) !important;
        color: #f87171 !important;
        border-left: 2px solid #ef4444;
        padding-left: 10px !important;
    }
    .sb-active-danger .sb-icon { color: #f87171 !important; }

    button.sidebar-link:hover {
        background-color: rgba(239,68,68,0.08) !important;
        color: #f87171 !important;
    }

    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: var(--scrollbar-hover); }

    /* Collapsed (PC) */
    #main-sidebar.collapsed { width: 60px !important; }
    #main-sidebar.collapsed .sidebar-text,
    #main-sidebar.collapsed .sb-section-label { opacity: 0; visibility: hidden; display: none !important; }
    #main-sidebar.collapsed .sidebar-link { justify-content: center !important; margin: 2px 4px !important; padding-left: 0 !important; padding-right: 0 !important; }
    #main-sidebar.collapsed .sidebar-link:hover { transform: translateY(-1px); }
    #main-sidebar.collapsed .sb-active { border-left: none !important; border-bottom: 2px solid #6366f1 !important; padding-left: 0 !important; }

    /* Mobile */
    @media (max-width: 768px) {
        #main-sidebar { position: fixed; top: 0; left: -240px; height: 100vh; transition: left 0.28s ease; }
        #main-sidebar.mobile-open { left: 0; box-shadow: 8px 0 40px rgba(0,0,0,0.2); }
    }

    /* Light-mode sidebar shadow */
    [data-theme="light"] #main-sidebar {
        box-shadow: 1px 0 8px rgba(0,0,0,0.06);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar       = document.getElementById('main-sidebar');
        const toggleBtn     = document.getElementById('toggle-sidebar');
        const toggleIcon    = toggleBtn.querySelector('i');
        const mobileToggleBtn = document.getElementById('mobile-sidebar-toggle');
        const mobileCloseBtn  = document.getElementById('close-sidebar-mobile');

        if (localStorage.getItem('sidebarState') === 'collapsed' && window.innerWidth > 768) {
            sidebar.classList.add('collapsed');
            toggleIcon.classList.replace('fa-align-right', 'fa-align-center');
        }

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'expanded');
            toggleIcon.classList.replace(
                isCollapsed ? 'fa-align-right' : 'fa-align-center',
                isCollapsed ? 'fa-align-center' : 'fa-align-right'
            );
        });

        mobileToggleBtn.addEventListener('click', () => sidebar.classList.add('mobile-open'));
        mobileCloseBtn.addEventListener('click',  () => sidebar.classList.remove('mobile-open'));

        document.addEventListener('click', function (e) {
            if (!sidebar.contains(e.target) && !mobileToggleBtn.contains(e.target)
                && window.innerWidth <= 768 && sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
            }
        });
    });
</script>