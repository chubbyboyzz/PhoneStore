@extends('admin.layouts.master')
@section('title', 'Thêm bài viết mới')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-4 pb-0">
        <h4 class="fw-bold text-dark">Thêm tin tức mới</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- Cột trái: Thông tin chính -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nội dung <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Cột phải: Thuộc tính & Hình ảnh -->
                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="draft">Bản nháp (Draft)</option>
                            <option value="published">Xuất bản (Published)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Hình ảnh (1-4 ảnh)</label>
                        <input type="file" name="images[]" id="imageInput" class="form-control" accept="image/*" multiple>
                        <small class="text-muted d-block mt-1">Hỗ trợ: jpg, png, webp (Tối đa 2MB/ảnh)</small>

                        <!-- Khu vực Preview Ảnh -->
                        <div id="imagePreview" class="d-flex flex-wrap gap-2 mt-3"></div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        <i class="bi bi-save me-2"></i> Lưu bài viết
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script xử lý Preview Ảnh siêu nhẹ -->
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('imagePreview');
    previewContainer.innerHTML = ''; // Xóa preview cũ
    const files = Array.from(e.target.files).slice(0, 4); // Giới hạn 4 ảnh UI

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.className = 'img-thumbnail object-fit-cover shadow-sm';
            img.style.width = '80px';
            img.style.height = '80px';
            previewContainer.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
