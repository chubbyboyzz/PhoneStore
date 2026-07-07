@extends('admin.layouts.master')

@section('title', 'Quản lý Khách hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-people-fill me-2 text-danger"></i> Danh sách Khách hàng</h3>
</div>

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white border-bottom py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 rounded-top-4">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="mb-0 w-100" style="max-width: 400px;">
            <div class="input-group shadow-sm">
                <input type="text" name="search" class="form-control border-secondary-subtle" placeholder="Nhập tên, SĐT, Email..." value="{{ request('search') }}">
                <button class="btn btn-primary fw-bold" type="submit"><i class="bi bi-search"></i> Tìm</button>

                @if(request()->filled('search'))
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary" title="Xóa tìm kiếm"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>

        <a href="{{ route('admin.customers.create') }}" class="btn btn-danger fw-bold shadow-sm text-nowrap">
            <i class="bi bi-person-plus-fill me-1"></i> Thêm khách hàng
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4">Khách hàng</th>
                        <th class="py-3">Liên hệ</th>
                        <th class="py-3">Địa chỉ</th>
                        <th class="py-3 text-center">Trạng thái</th>
                        <th class="py-3 text-center pe-4" style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $customer->name }}</td>
                        <td>
                            <div class="text-secondary mb-1"><i class="bi bi-envelope me-1"></i> {{ $customer->email }}</div>
                            <div class="text-secondary"><i class="bi bi-telephone me-1"></i> {{ $customer->phone ?? 'Chưa cập nhật' }}</div>
                        </td>
                        <td class="text-secondary" style="max-width: 250px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                            {{ $customer->address ?? 'Chưa cập nhật' }}
                        </td>
                        <td class="text-center">
                            @if($customer->is_active)
                                <span class="badge bg-success rounded-pill px-3">Hoạt động</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3">Bị khóa</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">

                                <form action="{{ route('admin.customers.toggle', $customer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $customer->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-circle shadow-sm" title="{{ $customer->is_active ? 'Khóa tài khoản' : 'Mở khóa' }}" onclick="return confirm('Xác nhận thay đổi trạng thái tài khoản này?')">
                                        <i class="bi {{ $customer->is_active ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                    </button>
                                </form>

                                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-primary rounded-circle shadow-sm" title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('CẢNH BÁO: Xóa khách hàng này vĩnh viễn?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle shadow-sm" title="Xóa tài khoản">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Chưa có khách hàng nào trên hệ thống.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3 rounded-bottom-4">
        {{ $customers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
