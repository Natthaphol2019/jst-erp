<div class="sidebar d-flex flex-column" style="width: 250px; min-height: 100vh; background-color: #343a40;">
    <h4 class="text-white text-center py-3 border-bottom border-secondary m-0">JST Industry</h4>
    
    <a href="{{ route('dashboard') }}" class="text-decoration-none text-light p-3 border-bottom border-secondary">
        📊 แดชบอร์ด
    </a>
    
    @if(in_array(auth()->user()->role, ['admin', 'hr']))
        <div class="text-secondary px-3 mt-3 mb-1" style="font-size: 0.8rem;">ระบบจัดการบุคคล (HR)</div>
        <a href="#" class="text-decoration-none text-light px-4 py-2 d-block">👥 จัดการพนักงาน</a>
        <a href="#" class="text-decoration-none text-light px-4 py-2 d-block">🏢 จัดการแผนก</a>
    @endif

    @if(in_array(auth()->user()->role, ['admin', 'inventory']))
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