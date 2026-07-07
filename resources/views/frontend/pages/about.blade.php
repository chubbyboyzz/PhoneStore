@extends('frontend.layouts.master')

@section('title', 'Giới thiệu - Nam Khuê Corporation')

@section('content')
<div class="page-header py-5 bg-light border-bottom">
    <div class="container text-center">
        <h1 class="fw-bolder text-uppercase mb-2" style="color: var(--nk-black);">Về Chúng Tôi</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-danger fw-semibold">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 static-content-card">
                <div class="card-body p-4 p-md-5">

                    <h3 class="fw-bold text-danger mb-4 border-start border-4 border-danger ps-3">NAM KHUÊ CORPORATION</h3>

                    <div class="content-body text-secondary lh-lg">
                        <p><strong>Nam Khuê Corporation</strong> tự hào là một trong những đơn vị tiên phong trong lĩnh vực phân phối sỉ phụ kiện điện thoại, thiết bị công nghệ và đồ chơi điện tử chính hãng tại thị trường Việt Nam.</p>

                        <h5 class="fw-bold text-dark mt-5 mb-3"><i class="bi bi-bullseye text-danger me-2"></i> Tầm nhìn & Sứ mệnh</h5>
                        <p>Chúng tôi hướng đến việc xây dựng một hệ sinh thái nguồn hàng B2B minh bạch, ổn định và tối ưu chi phí cho các đại lý bán lẻ. Sứ mệnh của Nam Khuê là giải quyết triệt để bài toán đứt gãy chuỗi cung ứng, mang lại lợi thế cạnh tranh tuyệt đối cho đối tác.</p>

                        <h5 class="fw-bold text-dark mt-5 mb-3"><i class="bi bi-shield-check text-danger me-2"></i> Cam kết của chúng tôi</h5>
                        <ul class="custom-list">
                            <li><strong>Nguồn gốc rõ ràng:</strong> 100% sản phẩm có hóa đơn chứng từ, xuất xứ minh bạch.</li>
                            <li><strong>Giá sỉ tận gốc:</strong> Không qua trung gian, chính sách chiết khấu lũy tiến hấp dẫn.</li>
                            <li><strong>Hậu mãi chuyên nghiệp:</strong> Tốc độ xử lý bảo hành nhanh chóng, quy trình số hóa 100%.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


