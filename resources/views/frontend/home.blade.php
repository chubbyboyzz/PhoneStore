@extends('frontend.layouts.master')

@section('title', 'Tổng kho Phụ kiện Điện thoại - Nam Khuê Corporation')

@section('content')
<div class="container py-5">

    {{-- Lập trình phòng thủ: Kiểm tra rò rỉ dữ liệu từ Controller --}}
    @if(!isset($products))
        <div class="alert alert-danger fw-bold border-0 shadow-sm rounded-4 p-4 text-center">
            <i class="bi bi-exclamation-triangle-fill fs-1 d-block mb-2"></i>
            <h4 class="fw-bold">LỖI RÒ RỈ DỮ LIỆU (DATA LEAK)</h4>
            <p class="mb-0">Controller không ném biến <code>$products</code> sang View hoặc nhầm tên biến trong hàm compact().</p>
        </div>
    @else
        <div class="row mb-5 align-items-center">
            <div class="col-12">
                <h2 class="fw-bolder text-uppercase mb-1" style="color: var(--nk-black); border-left: 6px solid var(--nk-red); padding-left: 16px;">
                    Sản phẩm phân phối
                </h2>
                <p class="text-secondary mb-0 ms-3 fw-medium">Hệ thống kho sỉ phụ kiện chính hãng Nam Khuê</p>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($products as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">

                    <div class="position-relative p-3 bg-white text-center rounded-top border-bottom" style="height: 220px;">
                        <a href="{{ route('product.detail', $product->id) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid h-100 object-fit-contain" alt="{{ $product->name }}">
                        </a>
                    </div>

                    <div class="card-body d-flex flex-column bg-light bg-opacity-50">

                        <a href="{{ route('product.detail', $product->id) }}" class="text-decoration-none">
                            <h6 class="card-title fw-bold text-dark text-truncate mb-2 hover-red" title="{{ $product->name }}">
                                {{ $product->name ?? 'Đang cập nhật tên' }}
                            </h6>
                        </a>

                        <div class="mb-4 mt-auto rounded p-2 bg-white border border-secondary-subtle">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small fw-semibold">Mã SP:</span>
                                <span class="text-danger fw-bolder font-monospace">{{ $product->sku ?? 'NK-UPDATING' }}</span>
                            </div>
                        </div>

                        <a href="https://zalo.me/090xxxxxxx?text=Xin chào, tôi cần báo giá mã: {{ $product->sku ?? '' }}" target="_blank" class="btn btn-danger w-100 fw-bold d-flex justify-content-center align-items-center gap-2 shadow-sm btn-zalo">
                            <i class="bi bi-chat-dots-fill"></i> BÁO GIÁ ZALO
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm border border-dashed">
                    <i class="bi bi-box-seam display-1 text-muted opacity-25 mb-3"></i>
                    <h5 class="text-muted fw-bold">Database hiện tại đang trống.</h5>
                    <p class="text-secondary mb-0">Chưa có bản ghi Product nào để hiển thị.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .product-card { transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); overflow: hidden; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(217, 0, 27, 0.1) !important; }

    /* Thiết lập lại thẻ a bọc tên sản phẩm để chữ không bị gạch chân khi bình thường */
    .product-card a.text-decoration-none h6 { transition: color 0.2s ease-in-out; }
    .product-card a.text-decoration-none:hover h6 { color: var(--nk-red) !important; }

    .btn-zalo { background-color: var(--nk-red); transition: all 0.2s ease-in-out; }
    .btn-zalo:hover { background-color: #b30015; transform: scale(1.02); }
</style>
@endpush
