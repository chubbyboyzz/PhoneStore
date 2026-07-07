@extends('admin.layouts.master')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-cart-check me-2 text-danger"></i> Quản lý Đơn hàng</h3>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-danger fw-bold rounded-3 shadow-sm px-4">
        <i class="bi bi-plus-circle-fill me-2"></i> TẠO ĐƠN HÀNG MỚI
    </a>
</div>
@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">{{ session('error') }}</div>
@endif


<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <div class="row mb-3">
                <div class="col-md-6 col-lg-4">
                    <form action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Tìm</button>

                            @if(request()->filled('search'))
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary" title="Xóa tìm kiếm"><i class="bi bi-x-lg"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4">Mã ĐH</th>
                        <th class="py-3">Khách hàng</th>
                        <th class="py-3">Ngày đặt</th>
                        <th class="py-3 text-end">Tổng tiền</th>
                        <th class="py-3 text-center">Trạng thái</th>
                        <th class="py-3 text-center pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $order->user->name ?? 'Khách lẻ' }}</div>
                            <small class="text-muted">{{ $order->user->phone ?? '' }}</small>
                        </td>
                        <td class="text-secondary">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end fw-bold text-danger">{{ number_format($order->total_price) }}đ</td>
                        <td class="text-center">
                            <!-- State Machine Mapping UI -->
                            @switch($order->status)
                                @case(1) <span class="badge bg-secondary rounded-pill px-3">Chờ xác nhận</span> @break
                                @case(2) <span class="badge bg-primary rounded-pill px-3">Đang xử lý</span> @break
                                @case(3) <span class="badge bg-info text-dark rounded-pill px-3">Đang giao</span> @break
                                @case(4) <span class="badge bg-success rounded-pill px-3">Hoàn thành</span> @break
                                @case(5) <span class="badge bg-danger rounded-pill px-3">Đã hủy</span> @break
                            @endswitch
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark rounded-circle" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Chưa có đơn hàng nào phát sinh.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
