@extends('frontend.layouts.master')

@section('title', 'Điều khoản sử dụng - Nam Khuê Corporation')

@section('content')
<div class="page-header py-5 bg-light border-bottom">
    <div class="container text-center">
        <h1 class="fw-bolder text-uppercase mb-2" style="color: var(--nk-black);">Điều khoản sử dụng</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-danger fw-semibold">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Điều khoản</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 static-content-card">
                <div class="card-body p-4 p-md-5">

                    <h3 class="fw-bold text-danger mb-4 border-start border-4 border-danger ps-3">ĐIỀU KHOẢN SỬ DỤNG B2B</h3>

                    <div class="content-body text-secondary lh-lg">
                        <p>Bằng việc truy cập, tham khảo sản phẩm và liên hệ nhận báo giá tại nền tảng kho sỉ Nam Khuê Corporation, đối tác (Đại lý/Khách sỉ) mặc định đồng ý và tuân thủ các điều khoản dưới đây:</p>

                        <h5 class="fw-bold text-dark mt-4 mb-3">1. Tính bảo mật giá cả (Confidentiality)</h5>
                        <p>Nam Khuê Corporation hoạt động dưới mô hình phân phối sỉ. Do đó, toàn bộ báo giá được cung cấp qua Zalo, Email hoặc văn bản là <strong>thỏa thuận bảo mật</strong> giữa Nam Khuê và đối tác.</p>
                        <ul class="custom-list text-danger">
                            <li>Mọi hành vi cố tình phát tán báo giá sỉ nội bộ ra thị trường bán lẻ (nhằm mục đích phá giá hoặc cạnh tranh không lành mạnh) sẽ dẫn đến việc hệ thống tự động khóa tài khoản và ngừng cung cấp hàng hóa vĩnh viễn.</li>
                        </ul>

                        <h5 class="fw-bold text-dark mt-4 mb-3">2. Quyền sở hữu trí tuệ</h5>
                        <ul class="custom-list">
                            <li>Toàn bộ hình ảnh sản phẩm, logo, tư liệu thiết kế và nội dung trên website này thuộc bản quyền của Nam Khuê Corporation.</li>
                            <li>Đối tác được phép tải và sử dụng hình ảnh sản phẩm để phục vụ mục đích kinh doanh bán lẻ của riêng mình.</li>
                            <li>Tuyệt đối <strong>không được phép</strong> sử dụng hình ảnh, logo Nam Khuê để mạo danh nhà phân phối nhằm lừa đảo hoặc trục lợi.</li>
                        </ul>

                        <h5 class="fw-bold text-dark mt-4 mb-3">3. Quy trình giải quyết tranh chấp</h5>
                        <p>Mọi tranh chấp phát sinh trong quá trình giao dịch (liên quan đến thanh toán, công nợ, giao nhận vận tải) sẽ được ưu tiên giải quyết thông qua thương lượng, hòa giải trên tinh thần đôi bên cùng có lợi. Quyết định cuối cùng thuộc về ban lãnh đạo Nam Khuê Corporation dựa trên chứng từ giao dịch (hóa đơn, phiếu xuất kho, log chat Zalo) hợp lệ.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
