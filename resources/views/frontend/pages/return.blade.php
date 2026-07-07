@extends('frontend.layouts.master')

@section('title', 'Chính sách đổi trả - Nam Khuê Corporation')

@section('content')
<div class="page-header py-5 bg-light border-bottom">
    <div class="container text-center">
        <h1 class="fw-bolder text-uppercase mb-2" style="color: var(--nk-black);">Chính sách đổi trả</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-danger fw-semibold">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đổi trả</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 static-content-card">
                <div class="card-body p-4 p-md-5">

                    <h3 class="fw-bold text-danger mb-4 border-start border-4 border-danger ps-3">CHÍNH SÁCH ĐỔI TRẢ</h3>

                    <div class="content-body text-secondary lh-lg">
                        <p>Chính sách đổi trả của Nam Khuê Corporation được thiết kế linh hoạt nhằm hỗ trợ tối đa cho các đại lý trong việc xoay vòng vốn và xử lý hàng lỗi, đảm bảo hiệu quả kinh doanh xuyên suốt.</p>

                        <h5 class="fw-bold text-dark mt-4 mb-3">1. Chính sách 1 đổi 1 (Hàng lỗi)</h5>
                        <p>Trong vòng <strong>07 ngày</strong> kể từ ngày nhập hàng, nếu phát hiện sản phẩm lỗi do nhà sản xuất, đối tác sẽ được đổi ngay sản phẩm mới cùng mã với các điều kiện:</p>
                        <ul class="custom-list">
                            <li>Sản phẩm còn nguyên vỏ hộp, tem mác và phụ kiện đi kèm.</li>
                            <li>Không có dấu hiệu rơi vỡ, chập cháy hoặc can thiệp phần cứng.</li>
                            <li>Có đối chiếu khớp với mã đơn hàng xuất kho trên hệ thống.</li>
                        </ul>

                        <h5 class="fw-bold text-dark mt-4 mb-3">2. Chính sách nhập lại hàng (Hỗ trợ tồn kho)</h5>
                        <p>Nhằm giảm thiểu rủi ro đọng vốn cho đại lý, Nam Khuê hỗ trợ nhập lại hàng tồn kho đối với các mã hàng bán chậm, áp dụng với các điều kiện sau:</p>
                        <ul class="custom-list">
                            <li>Hàng còn nguyên seal, chưa qua sử dụng, vỏ hộp không móp méo hay bạc màu.</li>
                            <li>Thời gian yêu cầu nhập lại không quá <strong>30 ngày</strong> kể từ ngày xuất kho.</li>
                            <li>Phí chiết khấu nhập lại (Phí lưu kho & xử lý bù giá): <strong>10% - 15%</strong> trên đơn giá nhập ban đầu (tùy thuộc vào tình trạng biến động giá của thị trường tại thời điểm trả).</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
