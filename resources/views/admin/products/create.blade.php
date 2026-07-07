@extends('admin.layouts.master')

@section('title', 'Thêm mới Sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Thêm mới Sản phẩm</h3>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
</div>

<!-- Form bắt buộc phải có enctype="multipart/form-data" để up ảnh -->
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- Cột Trái: Thông tin chính -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Thông tin cơ bản</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Ví dụ: iPhone 15 Pro Max" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hình ảnh đại diện</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                        <small class="text-muted">Định dạng hỗ trợ: JPG, PNG, WEBP. Tối đa 2MB.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Nhập thông số kỹ thuật, bài viết..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột Phải: Phân loại & Cấu hình -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Phân loại & Giá</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thương hiệu <span class="text-danger">*</span></label>
                        <select name="brand_id" class="form-select" required>
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" required min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số lượng kho <span class="text-danger">*</span></label>
                        <input type="number" name="stock_quantity" class="form-control" required min="0" value="10">
                    </div>

                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                        <label class="form-check-label fw-semibold" for="isActive">Kích hoạt bán</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary fw-bold py-2 rounded-3">
                            <i class="bi bi-save me-1"></i> LƯU SẢN PHẨM
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
