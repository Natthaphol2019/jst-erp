<div class="d-flex justify-content-end align-items-center mb-4 bg-white p-3 shadow-sm rounded">
    <span class="me-3">
        ผู้ใช้งาน: <strong>{{ auth()->user()->name }}</strong> 
        <span class="badge bg-primary ms-1">{{ strtoupper(auth()->user()->role) }}</span>
    </span>
</div>