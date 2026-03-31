<div class="sidebar d-flex flex-column" style="width: 250px; min-height: 100vh; background-color: #343a40;">
    <h4 class="text-white text-center py-3 border-bottom border-secondary m-0">JST Industry</h4>

    @php
        $dashRoute = match (auth()->user()->role) {
            'admin' => route('admin.dashboard'),
            'manager' => route('manager.dashboard'),
            'employee' => route('employee.dashboard'),
            default => route('dashboard'),
        };
    @endphp

    <a href="{{ $dashRoute }}"
        class="text-decoration-none text-light p-3 border-bottom border-secondary {{ request()->routeIs('*dashboard') ? 'bg-secondary' : '' }}">
        📊 แดชบอร์ด
    </a>

    @if (in_array(auth()->user()->role, ['admin', 'hr']))
        <div class="text-secondary px-3 mt-3 mb-1" style="font-size: 0.8rem;">ระบบจัดการบุคคล (HR)</div>

        <a href="{{ route('hr.employees.index') }}"
            class="text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.employees.*') ? 'bg-secondary' : '' }}">
            👥 จัดการพนักงาน
        </a>

        <a href="{{ route('hr.departments.index') }}"
            class="text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.departments.*') ? 'bg-secondary' : '' }}">
            🏢 จัดการแผนก
        </a>
        <a href="{{ route('hr.positions.index') }}"
            class="text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.positions.*') ? 'bg-secondary' : '' }}">
            💼 จัดการตำแหน่ง
        </a>
        <div class="text-secondary px-3 mt-4 mb-1" style="font-size: 0.8rem;">ระบบลงเวลา (Time)</div>
        <a href="{{ route('hr.time-records.batch') }}"
            class="text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.time-records.batch*') ? 'bg-secondary' : '' }}">
            ⏱️ บันทึกเวลา (รายวัน)
        </a>
        <a href="{{ route('hr.time-records.summary') }}"
            class="text-decoration-none text-light px-4 py-2 d-block {{ request()->routeIs('hr.time-records.summary') ? 'bg-secondary' : '' }}">
            📊 รายงานสรุป (รายเดือน)
        </a>
    @endif

    @if (in_array(auth()->user()->role, ['admin', 'inventory']))
        <div class="text-secondary px-3 mt-3 mb-1" style="font-size: 0.8rem;">ระบบคลังสินค้า</div>
        <a href="#" class="text-decoration-none text-light px-4 py-2 d-block">📦 รายการสินค้า/อุปกรณ์</a>
        <a href="#" class="text-decoration-none text-light px-4 py-2 d-block">📝 จัดการใบเบิก-ยืม</a>
    @endif

    <div class="mt-auto border-top border-secondary">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link text-danger w-100 text-start p-3 text-decoration-none">
                🚪 ออกจากระบบ
            </button>
        </form>
    </div>
</div>
