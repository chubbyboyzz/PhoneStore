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
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4">Khách hàng</th>
                        <th class="py-3">Liên hệ</th>
                        <th class="py-3">Địa chỉ</th>
                        <th class="py-3 text-center">Trạng thái</th>
                        <th class="py-3 text-center pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">
                            {{ $customer->name }}
                        </td>
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
                            <!-- Nút Khóa/Mở khóa an toàn qua form POST -->
                            <form action="{{ route('admin.customers.toggle', $customer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm {{ $customer->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-circle" title="{{ $customer->is_active ? 'Khóa tài khoản' : 'Mở khóa' }}" onclick="return confirm('Xác nhận thay đổi trạng thái tài khoản này?')">
                                    <i class="bi {{ $customer->is_active ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                </button>
                            </form>
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
    <div class="card-footer bg-white border-0 py-3">
        {{ $customers->links() }}
    </div>
</div>
@endsection
