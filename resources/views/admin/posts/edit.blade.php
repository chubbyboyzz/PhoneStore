@extends('admin.layouts.master')
@section('title', 'Sửa bài viết')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 pt-4 pb-0">
        <h4 class="fw-bold text-dark">Chỉnh sửa tin tức</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nội dung</label>
                        <textarea name="content" class="form-control" rows="10" required>{{ old('content', $post->content) }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Xuất bản</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tải lên ảnh mới (Sẽ thay thế ảnh cũ)</label>
                        <input type="file" name="images[]" id="imageInput" class="form-control" multiple>

                        <!-- Hiển thị ảnh hiện tại đang có trong DB -->
                        <div class="mt-3">
                            <label class="form-label text-muted small">Ảnh hiện tại:</label>
                            <div class="d-flex flex-wrap gap-2">
                                @if(is_array($post->images))
                                    @foreach($post->images as $img)
                                        <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning text-dark w-100 fw-bold py-2">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
