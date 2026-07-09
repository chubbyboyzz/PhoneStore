@extends('frontend.layouts.master')

@section('title', 'Lịch sử đơn hàng - Nam Khuê Corporation')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="bg-white rounded-4 shadow-sm border border-secondary-subtle overflow-hidden">
                <div class="p-4 bg-dark text-white text-center">
                    <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                    <small class="text-white-50">{{ Auth::user()->phone ?? 'Chưa cập nhật SĐT' }}</small>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('frontend.account.orders') }}" class="list-group-item list-group-item-action py-3 px-4 fw-bold text-danger bg-light border-start border-4 border-danger">
                        <i class="bi bi-bag-check-fill me-2"></i> Lịch sử đơn hàng
                    </a>
                    <a href="{{ route('frontend.account.profile') }}" class="list-group-item list-group-item-action py-3 px-4 fw-medium text-secondary">
                        <i class="bi bi-person-gear me-2"></i> Thông tin cá nhân
                    </a>

                    <form action="{{ route('frontend.logout') }}" method="POST" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action py-3 px-4 fw-medium text-secondary border-0 w-100 text-start rounded-0">
                            <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="bg-white p-4 rounded-4 shadow-sm border border-secondary-subtle h-100">
                <h4 class="fw-bold border-bottom pb-3 mb-4"><i class="bi bi-clipboard-data text-danger me-2"></i> Lịch sử mua hàng</h4>

                <div class="table-responsive">
                    <table class="table table-hover align-middle border">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">Mã đơn</th>
                                <th class="py-3">Ngày đặt</th>
                                <th class="py-3 text-end">Tổng tiền</th>
                                <th class="py-3 text-center">Trạng thái</th>
                                <th class="py-3 text-center">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="fw-bold text-dark">{{ $order->order_code ?? '#NK-'.$order->id }}</td>
                                <td class="text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end fw-bold text-danger">
                                    {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}đ
                                </td>
                                <td class="text-center">
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark rounded-pill">Chờ duyệt</span>
                                    @elseif($order->status == 'in_progress')
                                        <span class="badge bg-primary rounded-pill">Đang giao</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success rounded-pill">Hoàn thành</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Đã hủy</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-danger rounded-circle" title="Xem chi tiết">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-box-seam display-4 text-muted opacity-25 d-block mb-3"></i>
                                    <h6 class="text-muted fw-bold mb-1">Chưa có đơn hàng nào!</h6>
                                    <p class="text-secondary small mb-3">Ông chưa thực hiện giao dịch nào trên hệ thống.</p>
                                    <a href="{{ route('home') }}" class="btn btn-danger fw-bold shadow-sm px-4">Mua sắm ngay</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
