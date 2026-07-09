@extends('frontend.layouts.master')

@section('title', 'Giỏ hàng của bạn - Nam Khuê Corporation')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-cart3 text-danger me-2"></i> Xác nhận yêu cầu đặt hàng</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="bg-white p-4 rounded-4 shadow-sm border border-secondary-subtle">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset($details['thumbnail']) }}" alt="{{ $details['name'] }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                                    <small class="text-muted">Mã: {{ $details['sku'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-danger fw-semibold">{{ number_format($details['price'], 0, ',', '.') }}đ</td>
                                        <td class="text-center fw-bold">{{ $details['quantity'] }}</td>
                                        <td class="text-end text-danger fw-bold">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ</td>
                                        <td class="text-end">
                                            <a href="{{ route('frontend.cart.remove', $id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-white p-4 rounded-4 shadow-sm border border-secondary-subtle">
                    <h5 class="fw-bold border-bottom pb-3 mb-3">Thông tin đơn hàng</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 border-top pt-3">
                        <span class="fw-bold fs-5">TỔNG TIỀN:</span>
                        <span class="text-danger fw-bolder fs-4">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>

                    <form action="{{ route('frontend.cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 fw-bold py-3 rounded-3 shadow-sm text-uppercase">
                            <i class="bi bi-check2-circle fs-5 me-1"></i> Gửi yêu cầu đặt hàng
                        </button>
                    </form>
                    <p class="text-muted small text-center mt-3 mb-0">Hệ thống sẽ lưu đơn ở trạng thái Chờ duyệt. Nhân viên sẽ liên hệ lại với quý đại lý ngay lập tức.</p>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border border-dashed">
            <i class="bi bi-cart-x display-1 text-muted opacity-25 mb-3"></i>
            <h5 class="text-muted fw-bold">Giỏ hàng của ông đang trống!</h5>
            <p class="text-secondary">Hãy quay lại trang chủ để chọn thêm mặt hàng sỉ nhé.</p>
            <a href="{{ route('home') }}" class="btn btn-danger mt-3 fw-bold px-4">Tiếp tục chọn hàng</a>
        </div>
    @endif
</div>
@endsection
