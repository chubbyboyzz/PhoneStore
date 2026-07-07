@extends('admin.layouts.master')

@section('title', 'Cập nhật Sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Chỉnh sửa: {{ $product->name }}</h3>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Định tuyến giao thức HTTP chuẩn PUT -->

    <div class="row g-4">
        <!-- Khu vực Dữ liệu Lõi -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Thông tin cơ bản</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hình ảnh hiện tại</label>
                        <div class="mb-2">
                            <img src="{{ $product->thumbnail }}" alt="Preview" class="img-thumbnail rounded-3" style="max-height: 120px;">
                        </div>
                        <input type="file" name="thumbnail" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                        <small class="text-muted">Bỏ trống nếu không muốn thay đổi hình ảnh.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Khu vực Phân loại & Ràng buộc -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Phân loại & Giá</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thương hiệu <span class="text-danger">*</span></label>
                        <select name="brand_id" class="form-select" required>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số lượng kho <span class="text-danger">*</span></label>
                        <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0">
                    </div>

                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $product->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Kích hoạt bán</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning fw-bold py-2 rounded-3 text-dark">
                            <i class="bi bi-cloud-arrow-up me-1"></i> CẬP NHẬT DỮ LIỆU
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
