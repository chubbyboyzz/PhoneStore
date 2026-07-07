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
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-sticky" style="top: 100px;">
                <div class="bg-white p-4 text-center">
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="img-fluid object-fit-contain"
                         style="max-height: 400px; width: 100%;"
                         onerror="this.src='https://via.placeholder.com/400x400?text=No+Image'">
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
                    <div class="row mb-3">
                        <div class="product-price-box my-4 p-3 bg-light rounded-4 border border-secondary-subtle">
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
                        <div class="col-8 fw-bolder text-danger font-monospace fs-5">{{ $product->sku ?? 'Đang cập nhật' }}</div>
                    </div>
                    <hr class="text-secondary opacity-25">
                    <div class="row">
                        <div class="col-4 text-muted fw-semibold">Giao hàng:</div>
                        <div class="col-8 fw-medium">Toàn quốc (Qua chành xe / GHTK)</div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3 mb-5">
                    <a href="https://zalo.me/090xxxxxxx?text=Xin chào, tôi cần báo giá sỉ cho mã SP: {{ $product->sku }}"
                       target="_blank"
                       class="btn btn-danger btn-lg fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2 py-3 rounded-3"
                       style="transition: all 0.3s;">
                        <i class="bi bi-chat-dots-fill fs-4"></i> NHẬN BÁO GIÁ SỈ QUA ZALO
                    </a>
                    <a href="tel:090xxxxxxx" class="btn btn-outline-dark btn-lg fw-bold d-flex justify-content-center align-items-center gap-2 py-3 rounded-3">
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
@endsection
