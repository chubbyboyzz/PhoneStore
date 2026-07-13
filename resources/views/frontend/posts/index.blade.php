@extends('frontend.layouts.master')
@section('title', 'Tin tức & Cập nhật')

@section('content')
<div class="container py-5">
    <!-- Khu vực Tiêu đề trang -->
    <div class="row mb-5 text-center justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold text-dark display-5 mb-3">Tin tức Công nghệ</h1>
            <p class="text-muted fs-5">Cập nhật liên tục các xu hướng thị trường, đánh giá chuyên sâu và thông báo nội bộ từ hệ thống.</p>
        </div>
    </div>

    <!-- Khu vực Lưới bài viết (Grid System) -->
    <div class="row g-4">
        @forelse($posts as $post)
        <!-- Cột linh hoạt: 1 cột trên Mobile, 2 cột trên Tablet, 3 cột trên PC -->
        <div class="col-12 col-md-6 col-lg-4 d-flex">
            <div class="card border-0 shadow-sm rounded-4 hover-lift w-100 flex-column d-flex overflow-hidden">

                <!-- 1. Xử lý logic Hình ảnh (Bảo vệ UI) -->
                <a href="{{ route('posts.show', $post->slug) }}" class="d-block overflow-hidden position-relative bg-light">
                    @if(!empty($post->images) && is_array($post->images) && isset($post->images[0]))
                        <img src="{{ asset('storage/' . $post->images[0]) }}"
                             class="card-img-top object-fit-cover w-100 post-thumbnail"
                             alt="{{ $post->title }}"
                             loading="lazy">
                    @else
                        <!-- Fallback UI khi không có ảnh -->
                        <div class="card-img-top d-flex align-items-center justify-content-center w-100 post-thumbnail text-muted">
                            <i class="bi bi-image fs-1 opacity-50"></i>
                        </div>
                    @endif
                </a>

                <!-- 2. Nội dung Thẻ (Card Body) -->
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">Phân tích</span>
                        <time class="text-muted small fw-medium">
                            <i class="bi bi-clock me-1"></i>
                            {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                        </time>
                    </div>

                    <h5 class="card-title fw-bold lh-base mb-3">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-dark text-decoration-none stretched-link">
                            {{ Str::limit($post->title, 65, '...') }}
                        </a>
                    </h5>

                    <!-- Lọc bỏ thẻ HTML và giới hạn ký tự (Tránh XSS và vỡ layout) -->
                    <p class="card-text text-secondary mb-4 flex-grow-1">
                        {{ Str::limit(strip_tags($post->content), 120, '...') }}
                    </p>
                </div>
            </div>
        </div>

        @empty
        <!-- 3. Xử lý Trạng thái rỗng (Empty State) -->
        <div class="col-12">
            <div class="p-5 bg-light rounded-4 text-center border border-dashed">
                <i class="bi bi-journal-x display-1 text-muted mb-3 opacity-50 d-block"></i>
                <h4 class="text-secondary fw-semibold">Hệ thống chưa có bản tin nào được xuất bản.</h4>
                <p class="text-muted">Vui lòng quay lại sau để cập nhật thông tin mới nhất.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- 4. Điều hướng Phân trang (Pagination) -->
    @if($posts->hasPages())
    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>

<!-- Tích hợp CSS hướng đối tượng (OOCSS) để tái sử dụng component -->
<style>
    /* Ràng buộc tỷ lệ ảnh chuẩn 16:9 cho thumbnail */
    .post-thumbnail {
        height: 240px;
    }

    /* Hiệu ứng tương tác mượt mà (Micro-interactions) */
    .hover-lift {
        transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .card-img-top {
        transition: transform 0.5s ease;
    }
    .hover-lift:hover .card-img-top {
        transform: scale(1.05);
    }
</style>
@endsection
