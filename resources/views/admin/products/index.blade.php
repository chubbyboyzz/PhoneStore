@extends('admin.layouts.master')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Danh sách Sản phẩm</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary fw-semibold rounded-3">
        <i class="bi bi-plus-lg me-1"></i> Thêm sản phẩm
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <div class="row mb-3 mt-3 px-3">
                <div class="col-md-6 col-lg-4">
                    <form action="{{ route('admin.products.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Tìm</button>

                            @if(request()->filled('search'))
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" title="Xóa tìm kiếm"><i class="bi bi-x-lg"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4">Mã SKU</th>
                        <th class="py-3">Hình ảnh</th>
                        <th class="py-3">Tên sản phẩm</th>
                        <th class="py-3">Danh mục</th>

                        <!-- Đã cập nhật tiêu đề cột Giá -->
                        <th class="py-3 text-end" style="width: 150px;">Bảng giá (Lẻ / Sỉ)</th>

                        <th class="py-3 text-center">Trạng thái</th>
                        <th class="py-3 text-center pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $item)
                    <tr>
                        <td class="ps-4 text-muted fw-semibold">{{ $item->sku }}</td>
                        <td>
                            <img src="{{ $item->thumbnail }}" alt="{{ $item->name }}" class="rounded-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="fw-semibold text-dark">{{ $item->name }}</td>
                        <td>{{ $item->category->name ?? 'N/A' }}</td>

                        <!-- KHU VỰC ĐÃ CẬP NHẬT LOGIC HIỂN THỊ DỮ LIỆU KÉP -->
                        <td class="text-end">
                            <div class="fw-bold text-dark mb-1" title="Giá bán lẻ (Áp dụng cho khách thường)">
                                {{ number_format($item->price, 0, ',', '.') }} đ
                            </div>
                            <div class="fw-medium text-primary small" title="Giá bán sỉ (Áp dụng cho đại lý)">
                                Sỉ: {{ number_format($item->wholesale_price, 0, ',', '.') }} đ
                            </div>
                        </td>

                        <td class="text-center">
                            @if($item->is_active)
                                <span class="badge bg-success rounded-pill px-3">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3">Đã ẩn</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Xóa" onclick="return confirm('Hành động này không thể hoàn tác. Chắc chắn xóa?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i> Chưa có dữ liệu sản phẩm.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hiển thị thanh phân trang mặc định của Laravel -->
    <div class="card-footer bg-white border-0 py-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
