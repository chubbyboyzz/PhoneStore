@extends('admin.layouts.master')

@section('title', 'Thêm mới Sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Thêm mới Sản phẩm</h3>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
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
                        <label class="form-label fw-semibold">Bộ sưu tập ảnh (Gallery)</label>
                        <input type="file" name="gallery[]" class="form-control" multiple accept="image/png, image/jpeg, image/jpg, image/webp">
                        <small class="text-muted">Có thể chọn nhiều ảnh cùng lúc để làm ảnh review chi tiết (Giữ Ctrl để chọn nhiều).</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Nhập thông số kỹ thuật, bài viết..."></textarea>
                    </div>
                </div>
            </div>
        </div>

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
                        <!-- Thêm ID và sự kiện onchange -->
                        <select name="brand_id" id="brandSelect" class="form-select" required onchange="toggleNewBrand()">
                            <option value="">-- Chọn thương hiệu --</option>

                            <!-- Render danh sách có sẵn -->
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ (isset($product) && $product->brand_id == $brand->id) ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach

                            <!-- Option đặc biệt để kích hoạt tạo mới -->
                            <option value="NEW_BRAND" class="fw-bold text-primary">➕ Thêm thương hiệu mới...</option>
                        </select>

                        <!-- Ô input ẩn, chỉ hiện ra khi chọn NEW_BRAND -->
                        <input type="text" name="new_brand_name" id="newBrandInput" class="form-control mt-2 d-none border-primary" placeholder="Nhập tên thương hiệu muốn tạo mới...">
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


<script>
    function toggleNewBrand() {
        const select = document.getElementById('brandSelect');
        const input = document.getElementById('newBrandInput');

        if (select.value === 'NEW_BRAND') {
            input.classList.remove('d-none');
            input.setAttribute('required', 'required'); // Bắt buộc nhập nếu chọn tạo mới
        } else {
            input.classList.add('d-none');
            input.removeAttribute('required');
            input.value = ''; // Reset rác
        }
    }
</script>
@endsection
