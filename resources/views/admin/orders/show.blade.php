@extends('admin.layouts.master')

@section('title', 'Chi tiết Đơn hàng ' . $order->order_code)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-receipt-cutoff me-2 text-danger"></i> Chi tiết Đơn hàng: <span class="text-danger">{{ $order->order_code }}</span></h3>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3 shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">{{ session('success') }}</div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="fw-bold"><i class="bi bi-person-lines-fill text-primary me-2"></i>Thông tin Khách hàng</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="text-muted d-block small mb-1">Họ và tên:</span>
                    <strong class="fs-6">{{ $order->customer_name }}</strong>
                </div>
                <div class="mb-3">
                    <span class="text-muted d-block small mb-1">Số điện thoại:</span>
                    <strong class="fs-6">{{ $order->customer_phone }}</strong>
                </div>
                <div class="mb-3">
                    <span class="text-muted d-block small mb-1">Địa chỉ giao hàng:</span>
                    <strong class="fs-6">{{ $order->customer_address }}</strong>
                </div>
                <hr class="text-muted opacity-25">
                <div class="mb-0">
                    <span class="text-muted d-block small mb-1">Ngày đặt hàng:</span>
                    <strong class="fs-6">{{ $order->created_at->format('d/m/Y H:i:s') }}</strong>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-arrow-repeat text-warning me-2"></i>Cập nhật Trạng thái</h6>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT') <select name="status" class="form-select mb-3 border-secondary-subtle" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ duyệt (Pending)</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành (Completed)</option>
                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã hủy (Canceled)</option>
                    </select>
                    <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm">
                        CẬP NHẬT TIẾN ĐỘ
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom pb-3 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-box-seam text-danger me-2"></i>Danh sách Sản phẩm đã đặt</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Sản phẩm</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">SL</th>
                                <th class="text-end pe-4">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->details ?? [] as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                                    <small class="text-muted">Mã SP: {{ $item->product_sku }}</small>
                                </td>
                                <td class="text-center">{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                                <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                <td class="text-end pe-4 fw-bold text-danger">
                                    {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}đ
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Lỗi rò rỉ dữ liệu: Không tìm thấy chi tiết sản phẩm.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold py-3 fs-5">TỔNG CỘNG:</td>
                                <td class="text-end pe-4 fw-bolder text-danger fs-4 py-3">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
