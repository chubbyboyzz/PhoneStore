@extends('frontend.layouts.master')

@section('title', 'Chính sách bảo hành - Nam Khuê Corporation')

@section('content')
<div class="page-header py-5 bg-light border-bottom">
    <div class="container text-center">
        <h1 class="fw-bolder text-uppercase mb-2" style="color: var(--nk-black);">Chính sách bảo hành</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-danger fw-semibold">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bảo hành</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 static-content-card">
                <div class="card-body p-4 p-md-5">

                    <h3 class="fw-bold text-danger mb-4 border-start border-4 border-danger ps-3">CHÍNH SÁCH BẢO HÀNH</h3>

                    <div class="content-body text-secondary lh-lg">
                        <p>Để đảm bảo quyền lợi tối đa cho các đại lý, Nam Khuê Corporation áp dụng chính sách bảo hành điện tử theo tiêu chuẩn của nhà sản xuất.</p>

                        <h5 class="fw-bold text-dark mt-4 mb-3">1. Điều kiện được bảo hành</h5>
                        <ul class="custom-list">
                            <li>Sản phẩm còn trong thời hạn bảo hành (được tính từ ngày xuất kho trên hệ thống).</li>
                            <li>Tem bảo hành, mã SKU hoặc Serial Number còn nguyên vẹn, không có dấu hiệu cạo sửa, chắp vá.</li>
                            <li>Sản phẩm bị lỗi kỹ thuật do quá trình sản xuất.</li>
                        </ul>

                        <h5 class="fw-bold text-dark mt-4 mb-3">2. Trường hợp từ chối bảo hành</h5>
                        <ul class="custom-list text-muted">
                            <li>Sản phẩm bị rơi vỡ, biến dạng, vào nước do lỗi người sử dụng.</li>
                            <li>Tự ý can thiệp phần cứng hoặc sửa chữa tại các cơ sở không được ủy quyền.</li>
                            <li>Hết thời hạn bảo hành quy định.</li>
                        </ul>

                        <div class="alert alert-danger mt-4 bg-danger bg-opacity-10 border-0 text-dark">
                            <i class="bi bi-info-circle-fill text-danger me-2"></i> <strong>Lưu ý:</strong> Thời gian xử lý bảo hành cho khách sỉ dao động từ 3 - 7 ngày làm việc.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
