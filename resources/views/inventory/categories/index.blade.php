@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h2>🏷️ จัดการหมวดหมู่สินค้า</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('inventory.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> เพิ่มหมวดหมู่ใหม่
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อหมวดหมู่</th>
                        <th>รายละเอียด</th>
                        <th class="text-center">จำนวนสินค้า</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->description ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $cat->items_count }} รายการ</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('inventory.categories.edit', $cat->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> แก้ไข
                                </a>
                                <form action="{{ route('inventory.categories.destroy', $cat->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('คุณแน่ใจหรือว่าจะลบหมวดหมู่นี้?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> ลบ
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">ไม่มีข้อมูลหมวดหมู่สินค้า</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
