@extends('admin.layouts.master')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-cart-check me-2 text-danger"></i> Quản lý Đơn hàng</h3>
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
            <div class="row p-3 mb-0">
                <div class="col-md-6 col-lg-4">
                    <form action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Nhập mã ĐH hoặc SĐT..." value="{{ request('search') }}">
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
                        <td class="ps-4 fw-bold text-danger">{{ $order->order_code }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $order->customer_name ?? 'Khách lẻ' }}</div>
                            <small class="text-muted">{{ $order->customer_phone ?? '' }}</small>
                        </td>
                        <td class="text-secondary">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        <td class="text-center">
                            @switch($order->status)
                                @case('pending') <span class="badge bg-warning text-dark rounded-pill px-3">Chờ duyệt</span> @break
                                @case('completed') <span class="badge bg-success rounded-pill px-3">Hoàn thành</span> @break
                                @case('canceled') <span class="badge bg-danger rounded-pill px-3">Đã hủy</span> @break
                                @default <span class="badge bg-secondary rounded-pill px-3">{{ $order->status }}</span>
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
