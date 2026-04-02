<div class="sidebar d-flex flex-column shadow-sm" style="width: 250px; min-height: 100vh; background-color: #343a40;">
    <h4 class="text-white text-center py-4 border-bottom border-secondary m-0 fw-bold">
        <i class="bi bi-buildings me-2"></i> JST Industry
    </h4>

    @php
        // 🌟 ชี้เป้าให้ครบทุก Role ตามโฟลเดอร์ที่มีเลยครับ
        $dashRoute = match (auth()->user()->role) {
            'admin' => route('admin.dashboard'),
            'manager' => route('manager.dashboard'),
            'employee' => route('employee.dashboard'),
            'hr' => route('hr.dashboard'), // 👈 ชี้ไปที่ของ HR
            'inventory' => route('inventory.dashboard'), // 👈 ชี้ไปที่ของ Inventory
            default => url('/'), // กันเหนียวให้กลับหน้าแรกสุด
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
            <a href="#" class="sidebar-link text-decoration-none text-light px-4 py-2 d-block">📦
                รายการสินค้า/อุปกรณ์</a>
            <a href="#" class="sidebar-link text-decoration-none text-light px-4 py-2 d-block">📝
                จัดการใบเบิก-ยืม</a>
        @endif
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
    /* ลูกเล่นให้เมนูดูลื่นไหลและน่าใช้งานขึ้น */
    .sidebar-link {
        transition: all 0.2s ease-in-out;
        border-start: 4px solid transparent;
        /* เตรียมพื้นที่ไว้เผื่อตอน Active */
    }

    /* ตอนเอาเมาส์ชี้ เมนูจะขยับไปทางขวานิดนึงและสว่างขึ้น */
    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
        padding-left: 1.8rem !important;
    }

    /* ปุ่ม Logout ตอน Hover จะเป็นสีแดงเด่นๆ */
    .hover-bg-dark:hover {
        background-color: #212529 !important;
        color: #ff4d4d !important;
    }
</style>
