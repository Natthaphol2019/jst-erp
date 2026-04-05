<div class="sidebar d-flex flex-column shadow-sm" style="width: 250px; min-height: 100vh; background-color: #343a40;">
    <h4 class="text-white text-center py-4 border-bottom border-secondary m-0 fw-bold">
        <i class="bi bi-buildings me-2"></i> JST Industry
    </h4>

    @php
        // กำหนดเป้าหมาย Dashboard ตาม Role ของผู้ใช้งาน
        $dashRoute = match (auth()->user()->role) {
            'admin' => route('admin.dashboard'),
            'manager' => route('manager.dashboard'),
            'employee' => route('employee.dashboard'),
            'hr' => route('hr.dashboard'),
            'inventory' => route('inventory.dashboard'),
            default => url('/'),
        };
    @endphp

    <div class="flex-grow-1 overflow-auto pb-4">
        <a href="{{ $dashRoute }}"
            class="sidebar-link text-decoration-none text-light p-3 border-bottom border-secondary d-block {{ request()->routeIs('*dashboard') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            📊 แดชบอร์ด
        </a>

        @if (in_array(auth()->user()->role, ['admin', 'hr']))
            <div class="text-secondary fw-bold px-3 mt-4 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                ระบบจัดการบุคคล (HR)
            </div>

            <a href="{{ route('hr.employees.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.employees.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                👥 จัดการพนักงาน
            </a>

            <a href="{{ route('hr.departments.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.departments.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                🏢 จัดการแผนก
            </a>

            <a href="{{ route('hr.positions.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.positions.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                💼 จัดการตำแหน่ง
            </a>

            <div class="text-secondary fw-bold px-3 mt-4 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                ระบบลงเวลา (Time)
            </div>

            <a href="{{ route('hr.time-records.batch.select') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.time-records.batch.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                ⏱️ บันทึกเวลาจากบัตร
            </a>

            <a href="{{ route('hr.time-records.summary') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.time-records.summary') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                📊 รายงานสรุปรายเดือน
            </a>

            <a href="{{ route('hr.time-records.lock') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.time-records.lock*') ? 'bg-secondary border-start border-4 border-danger' : '' }}">
                🔒 ปิดงวดเวลาทำงาน
            </a>
        @endif

        @if (in_array(auth()->user()->role, ['admin', 'inventory']))
            <div class="text-secondary fw-bold px-3 mt-4 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                ระบบคลังสินค้า
            </div>

            <a href="{{ route('inventory.items.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.items.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                📦 รายการสินค้า/อุปกรณ์
            </a>

            <a href="{{ route('inventory.categories.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.categories.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                🏷️ จัดการหมวดหมู่สินค้า
            </a>

            <div class="text-secondary fw-bold px-3 mt-4 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                ระบบยืม-คืนอุปกรณ์
            </div>

            <a href="{{ route('inventory.borrowing.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.borrowing.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                🛍️ รายการยืมทั้งหมด
            </a>

            <a href="{{ route('inventory.borrowing.create') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.borrowing.create') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                ➕ สร้างใบยืมใหม่
            </a>

            <div class="text-secondary fw-bold px-3 mt-4 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                ระบบเบิกอุปทาน
            </div>

            <a href="{{ route('inventory.requisition.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.requisition.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                📋 รายการเบิกทั้งหมด
            </a>

            <a href="{{ route('inventory.requisition.create') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.requisition.create') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                ➕ สร้างใบเบิกใหม่
            </a>

            <div class="text-secondary fw-bold px-3 mt-4 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                รายงานคลังสินค้า
            </div>

            <a href="{{ route('inventory.transactions.index') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.transactions.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                📊 ประวัติเคลื่อนไหวสต๊อก
            </a>

            <a href="{{ route('inventory.transactions.summary') }}"
                class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('inventory.transactions.summary') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
                📈 สรุปยอดคงเหลือ
            </a>
        @endif
    </div>

    @if (auth()->user()->role === 'admin')
    <div class="border-top border-secondary">
        <div class="text-secondary fw-bold px-3 mt-3 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
            ระบบผู้ดูแล (Admin)
        </div>

        <a href="{{ route('admin.activity-logs.index') }}"
            class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('admin.activity-logs.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            <i class="bi bi-clipboard2-pulse me-2"></i> บันทึกกิจกรรม
        </a>

        <div class="text-secondary fw-bold px-3 mt-3 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
            เครื่องมือระบบ
        </div>

        <a href="{{ route('admin.imports.employees.form') }}"
            class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('admin.imports.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            <i class="bi bi-file-earmark-arrow-up me-2"></i> นําเข้าข้อมูล
        </a>

        <a href="{{ route('admin.backups.index') }}"
            class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('admin.backups.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            <i class="bi bi-database me-2"></i> สํารองข้อมูล
        </a>

        <a href="{{ route('admin.health') }}"
            class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('admin.health') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            <i class="bi bi-heart-pulse me-2"></i> ตรวจสอบระบบ
        </a>
    </div>
    @endif

    <div class="border-top border-secondary">
        <div class="text-secondary fw-bold px-3 mt-3 mb-2" style="font-size: 0.85rem; letter-spacing: 0.5px;">
            บัญชีผู้ใช้
        </div>

        @php
            $sidebarUnreadCount = auth()->user()->unreadNotifications()->count();
        @endphp
        <a href="{{ route('notifications.index') }}"
            class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('notifications.*') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            <i class="bi bi-bell me-2"></i> การแจ้งเตือน
            @if($sidebarUnreadCount > 0)
                <span class="badge bg-danger ms-1">{{ $sidebarUnreadCount > 99 ? '99+' : $sidebarUnreadCount }}</span>
            @endif
        </a>

        <a href="{{ route('profile.edit') }}"
            class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('profile.edit') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            👤 แก้ไขข้อมูลส่วนตัว
        </a>

        <a href="{{ route('profile.change-password') }}"
            class="sidebar-link text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('profile.change-password') ? 'bg-secondary border-start border-4 border-primary' : '' }}">
            🔑 เปลี่ยนรหัสผ่าน
        </a>
    </div>

    <div class="mt-auto border-top border-secondary bg-dark">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit"
                class="btn btn-link text-danger fw-bold w-100 text-start p-3 text-decoration-none rounded-0 hover-bg-dark">
                <i class="bi bi-box-arrow-right me-2"></i> 🚪 ออกจากระบบ
            </button>
        </form>
    </div>
</div>

<style>
    /* สไตล์สำหรับการ Hover และสถานะ Active เพื่อให้เมนูดูลื่นไหล */
    .sidebar-link {
        transition: all 0.2s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
        padding-left: 1.8rem !important;
    }

    .hover-bg-dark:hover {
        background-color: #212529 !important;
        color: #ff4d4d !important;
    }
</style>