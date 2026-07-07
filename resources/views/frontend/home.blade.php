@extends('frontend.layouts.master')

@section('title', 'Tổng kho Phụ kiện Điện thoại - Nam Khuê Corporation')

@section('content')
<div class="container py-5">

    @if(!isset($products))
        <div class="alert alert-danger fw-bold border-0 shadow-sm rounded-4 p-4 text-center">
            <i class="bi bi-exclamation-triangle-fill fs-1 d-block mb-2"></i>
            <h4 class="fw-bold">LỖI RÒ RỈ DỮ LIỆU</h4>
            <p class="mb-0">Controller không ném biến <code>$products</code> sang View.</p>
        </div>
    @else
        <div class="row mb-4 align-items-center">
            <div class="col-12">
                <h2 class="fw-bolder text-uppercase mb-1" style="color: var(--nk-black); border-left: 6px solid var(--nk-red); padding-left: 16px;">
                    Sản phẩm phân phối
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="bg-white p-4 rounded-4 shadow-sm border border-secondary-subtle sticky-top" style="top: 80px; z-index: 1;">
                    <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="bi bi-funnel-fill text-danger me-2"></i> Bộ lọc tìm kiếm</h5>

                    <div class="text-center py-5 text-muted fst-italic">
                        <i class="bi bi-tools fs-1 mb-3 d-block opacity-50"></i>
                        <p class="mb-0 small">Khu vực này đang được chừa lại để tích hợp bộ lọc nâng cao (Mức giá, ROM, HĐH...) ở giai đoạn tiếp theo.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">

                <div class="bg-white p-3 rounded-4 shadow-sm border border-secondary-subtle mb-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

                    <form action="{{ route('home') }}" method="GET" class="flex-grow-1 mb-0 w-100">
                        @if(request()->filled('category')) <input type="hidden" name="category" value="{{ request()->category }}"> @endif
                        @if(request()->filled('brand')) <input type="hidden" name="brand" value="{{ request()->brand }}"> @endif
                        @if(request()->filled('sort')) <input type="hidden" name="sort" value="{{ request()->sort }}"> @endif

                        <div class="input-group">
                            <input type="text" name="search" class="form-control border-secondary-subtle bg-light" placeholder="Nhập tên hoặc mã SKU sản phẩm..." value="{{ request()->search }}">
                            <button class="btn btn-danger px-4 fw-bold text-nowrap" type="submit"><i class="bi bi-search me-1"></i> Tìm kiếm</button>
                        </div>
                    </form>

                    <form action="{{ route('home') }}" method="GET" class="d-flex align-items-center mb-0 flex-shrink-0">
                        @if(request()->filled('category')) <input type="hidden" name="category" value="{{ request()->category }}"> @endif
                        @if(request()->filled('brand')) <input type="hidden" name="brand" value="{{ request()->brand }}"> @endif
                        @if(request()->filled('search')) <input type="hidden" name="search" value="{{ request()->search }}"> @endif

                        <label class="text-nowrap me-2 fw-medium text-muted small">Sắp xếp:</label>
                        <select name="sort" class="form-select border-secondary-subtle fw-medium bg-light" onchange="this.form.submit()" style="min-width: 160px;">
                            <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>Mới cập nhật</option>
                            <option value="oldest" {{ request()->sort == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="name_asc" {{ request()->sort == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                        </select>
                    </form>
                </div>

                <div class="row row-cols-2 row-cols-md-3 g-4">
                    @forelse($products as $product)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="position-relative p-3 bg-white text-center rounded-top border-bottom" style="height: 220px;">
                                <a href="{{ route('product.detail', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid h-100 object-fit-contain" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/200?text=No+Image'">
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
                    <div class="col-12 text-center py-5 w-100">
                        <div class="p-5 bg-white rounded-4 shadow-sm border border-dashed">
                            <i class="bi bi-search display-1 text-muted opacity-25 mb-3"></i>
                            <h5 class="text-muted fw-bold">Không tìm thấy sản phẩm nào!</h5>
                            <p class="text-secondary mb-0">Thử thay đổi từ khóa tìm kiếm hoặc bỏ bớt bộ lọc.</p>
                            <a href="{{ route('home') }}" class="btn btn-outline-danger mt-3 fw-bold"><i class="bi bi-arrow-repeat me-1"></i> Đặt lại toàn bộ</a>
                        </div>
                    </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .product-card { transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); overflow: hidden; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(217, 0, 27, 0.1) !important; }
    .product-card a.text-decoration-none h6 { transition: color 0.2s ease-in-out; }
    .product-card a.text-decoration-none:hover h6 { color: var(--nk-red) !important; }
    .btn-zalo { background-color: var(--nk-red); transition: all 0.2s ease-in-out; }
    .btn-zalo:hover { background-color: #b30015; transform: scale(1.02); }
</style>
@endpush
