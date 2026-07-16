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
                                    <th class="text-center" style="width: 150px;">Số lượng</th>
                                    <th class="text-end" style="width: 130px;">Thành tiền</th>
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


                                        <td>
                                            <div class="input-group input-group-sm mx-auto" style="width: 140px;">
                                                <button class="btn btn-outline-secondary btn-qty flex-shrink-0" type="button" data-action="minus" data-id="{{ $id }}">-</button>

                                                <!-- Thay đổi max-width thành width cố định 80px, thêm max="999999" và class hide-spinners -->
                                                <input type="number" class="form-control text-center input-qty fw-bold hide-spinners"
                                                       id="qty-{{ $id }}"
                                                       data-id="{{ $id }}"
                                                       value="{{ $details['quantity'] }}"
                                                       min="1"
                                                       max="999999"
                                                       style="width: 80px;">

                                                <button class="btn btn-outline-secondary btn-qty flex-shrink-0" type="button" data-action="plus" data-id="{{ $id }}">+</button>
                                            </div>
                                        </td>

                                        <!-- Cột thành tiền được gắn ID để JS trỏ vào update -->
                                        <td class="text-end text-danger fw-bold item-total" id="item-total-{{ $id }}">
                                            {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ
                                        </td>

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
                <div class="bg-white p-4 rounded-4 shadow-sm border border-secondary-subtle sticky-top" style="top: 100px;">
                    <h5 class="fw-bold border-bottom pb-3 mb-3">Thông tin đơn hàng</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính:</span>
                        <!-- ID cart-subtotal -->
                        <span class="fw-bold cart-subtotal">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 border-top pt-3">
                        <span class="fw-bold fs-5">TỔNG TIỀN:</span>
                        <!-- ID cart-total -->
                        <span class="text-danger fw-bolder fs-4 cart-total">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>

                    <form action="{{ route('frontend.cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 fw-bold py-3 rounded-3 shadow-sm text-uppercase">
                            <i class="bi bi-check2-circle fs-5 me-1"></i> Gửi yêu cầu đặt hàng
                        </button>
                    </form>
                    <p class="text-muted small text-center mt-3 mb-0">Hệ thống sẽ lưu đơn ở trạng thái Chờ duyệt. Nhân viên sẽ liên hệ lại ngay lập tức.</p>
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

<!-- SCRIPTS XỬ LÝ LOGIC GIỎ HÀNG THÔNG MINH -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const qtyButtons = document.querySelectorAll('.btn-qty');
    const qtyInputs = document.querySelectorAll('.input-qty');

    // Hàm gọi API Fetch gửi lên Controller
    async function updateCart(productId, quantity) {
        try {
            const response = await fetch('{{ route('frontend.cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Rào chắn bảo mật chống giả mạo request
                },
                body: JSON.stringify({
                    id: productId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (data.success) {
                // Update UI DOM: Thành tiền của 1 món
                document.getElementById('item-total-' + productId).innerText = data.item_total_formatted;

                // Update UI DOM: Tổng tiền đơn hàng
                document.querySelectorAll('.cart-subtotal, .cart-total').forEach(el => {
                    el.innerText = data.cart_total_formatted;
                });
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            alert('Có lỗi xảy ra khi cập nhật giỏ hàng. Vui lòng tải lại trang.');
        }
    }

    // Bắt sự kiện bấm nút Cộng / Trừ
    qtyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            const inputEl = document.getElementById('qty-' + id);
            let currentVal = parseInt(inputEl.value) || 1;

            if (action === 'plus') {
                currentVal++;
            } else if (action === 'minus' && currentVal > 1) {
                currentVal--;
            }

            inputEl.value = currentVal;
            updateCart(id, currentVal); // Bắn API
        });
    });

    // Bắt sự kiện người dùng tự gõ số bằng bàn phím (nâng cao UX)
    qtyInputs.forEach(input => {
        input.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            let currentVal = parseInt(this.value);

            // Phòng thủ: Cấm gõ số âm hoặc chữ cái
            if (isNaN(currentVal) || currentVal < 1) {
                currentVal = 1;
                this.value = currentVal;
            }

            updateCart(id, currentVal); // Bắn API
        });
    });
});
</script>
@endsection
