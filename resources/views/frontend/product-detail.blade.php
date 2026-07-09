@extends('frontend.layouts.master')

@section('title', $product->name . ' - Nam Khuê Corporation')

@section('content')
<div class="bg-light py-3 border-bottom mb-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-danger fw-semibold">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Sản phẩm</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 200px;">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5">

        <div class="col-md-5">
            <div class="position-sticky" style="top: 100px;">

                <div class="card border-0 shadow-sm rounded-4 mb-3 d-flex justify-content-center align-items-center overflow-hidden" style="height: 400px; background-color: #fff;">
                    <img id="mainProductImage"
                         src="{{ asset($product->thumbnail) }}"
                         alt="{{ $product->name }}"
                         class="img-fluid h-100 object-fit-contain p-3"
                         onerror="this.src='https://via.placeholder.com/400x400?text=No+Image'">
                </div>

                <div class="d-flex gap-2 overflow-x-auto pb-2 thumbnail-container" style="scrollbar-width: thin;">

                    <div class="thumbnail-item border border-2 border-danger rounded-3 overflow-hidden flex-shrink-0" style="width: 80px; height: 80px; cursor: pointer;" onclick="changeMainImage(this, '{{ asset($product->thumbnail) }}')">
                        <img src="{{ asset($product->thumbnail) }}" class="w-100 h-100 object-fit-contain p-1 bg-white" onerror="this.src='https://via.placeholder.com/80x80?text=No+Img'">
                    </div>

                    @if(!empty($product->gallery) && is_array($product->gallery))
                        @foreach($product->gallery as $imagePath)
                            <div class="thumbnail-item border border-1 rounded-3 overflow-hidden flex-shrink-0 opacity-75" style="width: 80px; height: 80px; cursor: pointer;" onclick="changeMainImage(this, '{{ asset($imagePath) }}')">
                                <img src="{{ asset($imagePath) }}" class="w-100 h-100 object-fit-contain p-1 bg-white" onerror="this.src='https://via.placeholder.com/80x80?text=No+Img'">
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>

        <div class="col-md-7">
            <div class="product-info ps-md-3">
                <div class="badge bg-danger bg-opacity-10 text-danger border border-danger mb-3 px-3 py-2 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> Tình trạng: Sẵn kho sỉ
                </div>

                <h1 class="fw-bolder text-dark mb-4" style="font-size: 2rem;">{{ $product->name }}</h1>

                <div class="bg-light rounded-4 p-4 mb-4 border">
                    <div class="product-price-box mb-4 p-3 bg-white rounded-4 border border-secondary-subtle shadow-sm">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted fw-semibold">Giá phân phối sỉ:</span>

                            @auth
                                <span class="text-danger fw-bolder fs-3">
                                    {{ number_format($product->price ?? 0, 0, ',', '.') }}đ
                                </span>
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 ms-2 rounded-pill px-3">
                                    <i class="bi bi-check-circle-fill me-1"></i> Giá đại lý chính thức
                                </span>
                            @else
                                <div class="d-flex align-items-center gap-3">
                                    <span class="text-secondary fw-bold fst-italic">🔒 Giá bảo mật</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập để xem giá sỉ
                                    </button>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-4 text-muted fw-semibold">Mã sản phẩm:</div>
                        <div class="col-8 fw-bolder text-danger font-monospace fs-5">{{ $product->sku ?? 'Đang cập nhật' }}</div>
                    </div>

                    <hr class="text-secondary opacity-25">

                    <div class="row">
                        <div class="col-4 text-muted fw-semibold">Giao hàng:</div>
                        <div class="col-8 fw-medium">Toàn quốc (Qua chành xe / GHTK)</div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3 mb-5">
                    <a href="https://zalo.me/0862.542.394?text=Xin chào, tôi cần báo giá sỉ cho mã SP: {{ $product->sku }}"
                       target="_blank"
                       class="btn btn-danger btn-lg fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2 py-3 rounded-3"
                       style="transition: all 0.3s;">
                        <i class="bi bi-chat-dots-fill fs-4"></i> NHẬN BÁO GIÁ SỈ QUA ZALO
                    </a>
                    <a href="tel:0862.542.394" class="btn btn-outline-dark btn-lg fw-bold d-flex justify-content-center align-items-center gap-2 py-3 rounded-3">
                        <i class="bi bi-telephone-fill fs-5"></i> GỌI HOTLINE TƯ VẤN NGAY
                    </a>
                </div>

                <h4 class="fw-bold border-bottom border-danger border-3 d-inline-block pb-2 mb-4">Mô tả sản phẩm</h4>
                <div class="product-description text-secondary lh-lg text-wrap overflow-hidden">
                    @if(isset($product->description) && $product->description != '')
                        {!! $product->description !!}
                    @else
                        <p class="fst-italic">Nội dung mô tả chi tiết cho sản phẩm này đang được cập nhật...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImage(element, imageUrl) {
        // 1. Đổi ảnh chính
        document.getElementById('mainProductImage').src = imageUrl;

        // 2. Tẩy viền đỏ ở tất cả ảnh nhỏ
        let thumbnails = document.querySelectorAll('.thumbnail-item');
        thumbnails.forEach(function(thumb) {
            thumb.classList.remove('border-danger', 'border-2');
            thumb.classList.add('border-1', 'opacity-75');
        });

        // 3. Tô viền đỏ cho ảnh đang bấm
        element.classList.remove('border-1', 'opacity-75');
        element.classList.add('border-danger', 'border-2');
    }
</script>

<style>
    /* CSS làm đẹp thanh cuộn dưới ảnh */
    .thumbnail-container::-webkit-scrollbar {
        height: 6px;
    }
    .thumbnail-container::-webkit-scrollbar-thumb {
        background-color: #dee2e6;
        border-radius: 10px;
    }
    .thumbnail-item {
        transition: all 0.2s ease-in-out;
    }
    .thumbnail-item:hover {
        opacity: 1 !important;
        border-color: #dc3545 !important;
    }
</style>
@endsection
