@extends('admin.layouts.master')

@section('title', 'Tổng quan Hệ thống')

@section('content')
<!-- Tiêu đề trang -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Tổng quan hệ thống</h3>
</div>

<!-- KHU VỰC 1: CÁC THẺ CHỈ SỐ (METRICS CARDS) -->
<div class="row mb-4 g-4">
    <!-- Đơn hàng mới -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white h-100 rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-white-50 fw-semibold text-uppercase">Đơn hàng mới</p>
                        <h2 class="fw-bold mb-0">150</h2>
                    </div>
                    <i class="bi bi-cart-plus fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Doanh thu -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white h-100 rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-white-50 fw-semibold text-uppercase">Doanh thu tháng</p>
                        <h2 class="fw-bold mb-0">34.5M</h2>
                    </div>
                    <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng Sản phẩm (Dynamic Data) -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white h-100 rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-white-50 fw-semibold text-uppercase">Tổng sản phẩm</p>
                        <h2 class="fw-bold mb-0">{{ number_format($totalProducts ?? 0) }}</h2>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Khách hàng -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark h-100 rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 text-dark-50 fw-semibold text-uppercase opacity-75">Khách hàng</p>
                        <h2 class="fw-bold mb-0">1,245</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KHU VỰC 2: PHÂN TÍCH CHI TIẾT & HÀNH ĐỘNG (LAYOUT TỶ LỆ 8:4) -->
<div class="row g-4">

    <!-- CỘT TRÁI (8/12): BẢNG TỒN KHO CHI TIẾT -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold text-dark"><i class="bi bi-list-check me-2"></i>Chi tiết Tồn kho Sản phẩm</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 ps-3 border-0 rounded-start">Tên sản phẩm</th>
                                <th class="py-3 text-end pe-4 border-0 rounded-end" style="width: 200px;">Số lượng trong kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php /** @var \App\Models\Product $item */ @endphp
                            @forelse($inventoryProducts ?? [] as $item)
                                <tr>
                                    <td class="ps-3 fw-semibold text-secondary border-bottom-0 pt-3">
                                        <a href="{{ route('admin.products.edit', $item->id) }}" class="text-decoration-none text-dark hover-primary">
                                            {{ $item->name }}
                                        </a>
                                    </td>
                                    <td class="text-end pe-4 border-bottom-0 pt-3">
                                        @if($item->stock_quantity > 10)
                                            <span class="badge bg-success rounded-pill px-3 py-2 fs-6 shadow-sm">{{ $item->stock_quantity }} cái</span>
                                        @elseif($item->stock_quantity > 0)
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-6 shadow-sm">{{ $item->stock_quantity }} cái</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-2 fs-6 shadow-sm">Hết hàng</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                    Chưa có dữ liệu tồn kho.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- CỘT PHẢI (4/12): THAO TÁC NHANH & CẢNH BÁO -->
    <div class="col-md-4">

        <!-- Module 2.1: Thao tác nhanh -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
            <div class="card-body p-4">
                <h6 class="fw-bold text-white mb-3"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Thao tác nhanh</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-light text-primary text-start fw-bold py-2 shadow-sm rounded-3">
                        <i class="bi bi-plus-circle-fill me-2"></i> Thêm Sản phẩm
                    </a>
                    <a href="#" class="btn btn-outline-light text-start fw-semibold py-2 rounded-3 border-0 text-white-50 hover-white">
                        <i class="bi bi-tags me-2"></i> Quản lý Danh mục
                    </a>

                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-light text-start fw-semibold py-2 rounded-3 border-0 text-white-50 hover-white">
                        <i class="bi bi-newspaper me-2"></i> Quản lý Tin tức
                    </a>
                </div>
            </div>
        </div>

        <!-- Module 2.2: Cảnh báo hết hàng (UI Template) -->
        <div class="card border-0 shadow-sm rounded-4 border-top border-danger border-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold text-danger mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Cảnh báo hết hàng</h6>
            </div>
            <div class="card-body p-0 mt-2">
                <ul class="list-group list-group-flush">
                    <!-- Dữ liệu Mockup chờ tích hợp backend -->
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center border-bottom">
                        <div>
                            <span class="d-block fw-semibold text-dark text-truncate" style="max-width: 180px;">Sạc dự phòng 20000mAh</span>
                            <small class="text-danger fw-bold"><i class="bi bi-arrow-down-short"></i> Còn 2 cái</small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">Nhập</a>
                    </li>
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center border-bottom-0">
                        <div>
                            <span class="d-block fw-semibold text-dark text-truncate" style="max-width: 180px;">Tai nghe Bluetooth</span>
                            <small class="text-danger fw-bold"><i class="bi bi-x-circle"></i> Hết hàng</small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">Nhập</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
