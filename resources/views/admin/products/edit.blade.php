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
    @method('PUT') <div class="row g-4">
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
                        <label class="form-label fw-semibold">Bộ sưu tập ảnh (Gallery)</label>
                        @if(!empty($product->gallery) && is_array($product->gallery))
                            <div class="d-flex flex-wrap gap-2 mb-2 p-2 bg-light rounded border border-secondary-subtle">
                                @foreach($product->gallery as $img)
                                    <img src="{{ $img }}" class="img-thumbnail shadow-sm rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                                @endforeach
                            </div>
                        @endif
                        <input type="file" name="gallery[]" class="form-control" multiple accept="image/png, image/jpeg, image/jpg, image/webp">
                        <small class="text-muted text-danger fw-medium d-block mt-1">Lưu ý: Up ảnh mới sẽ xóa bộ ảnh cũ và ghi đè bằng bộ mới này.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
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
                        <label class="form-label fw-semibold">Giá bán lẻ (VNĐ) <span class="text-danger">*</span></label>
                        <!-- Thêm ID retailPrice để JS gọi -->
                        <input type="number" name="price" id="retailPrice" class="form-control" value="{{ old('price', $product->price ?? '') }}" required min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-primary">Giá bán sỉ (VNĐ) <span class="text-danger">*</span></label>
                        <!-- Thêm ID wholesalePrice để JS gọi -->
                        <input type="number" name="wholesale_price" id="wholesalePrice" class="form-control border-primary" value="{{ old('wholesale_price', $product->wholesale_price ?? '') }}" required min="0">

                        <!-- Dòng cảnh báo thời gian thực ẩn -->
                        <small id="priceWarning" class="text-danger d-none fw-medium mt-1">
                            <i class="bi bi-exclamation-triangle-fill"></i> Cảnh báo: Giá sỉ đang lớn hơn hoặc bằng giá lẻ!
                        </small>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const retailInput = document.getElementById('retailPrice');
    const wholesaleInput = document.getElementById('wholesalePrice');
    const warningMsg = document.getElementById('priceWarning');
    const submitBtn = document.querySelector('button[type="submit"]');

    function validatePricing() {
        const retail = parseFloat(retailInput.value) || 0;
        const wholesale = parseFloat(wholesaleInput.value) || 0;

        // Nếu người dùng đã nhập cả 2 giá và Giá sỉ >= Giá lẻ
        if (wholesale > 0 && retail > 0 && wholesale >= retail) {
            warningMsg.classList.remove('d-none');
            wholesaleInput.classList.add('is-invalid');
            submitBtn.disabled = true; // Khóa nút Lưu
        } else {
            warningMsg.classList.add('d-none');
            wholesaleInput.classList.remove('is-invalid');
            submitBtn.disabled = false; // Mở khóa
        }
    }

    // Lắng nghe sự kiện gõ phím thời gian thực (Real-time Validation)
    retailInput.addEventListener('input', validatePricing);
    wholesaleInput.addEventListener('input', validatePricing);
});
</script>
@endsection
