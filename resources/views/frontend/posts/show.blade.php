@extends('frontend.layouts.master')
{{-- Nếu ông chưa có layout frontend, hãy đổi thành tên layout ông đang dùng cho trang web --}}

@section('title', $post->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- 1. Header Bài viết -->
            <header class="mb-4">
                <h1 class="fw-bold mb-3 text-dark">{{ $post->title }}</h1>
                <div class="text-muted small">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : $post->created_at->format('d/m/Y H:i') }}
                    <span class="mx-2">|</span>
                    <span class="badge bg-primary">Tin tức</span>
                </div>
            </header>

            <!-- 2. Thuật toán hiển thị Layout Ảnh (Smart UI) -->
            @if(!empty($post->images) && is_array($post->images))
                <div class="post-gallery mb-4">
                    @php $imageCount = count($post->images); @endphp

                    @if($imageCount == 1)
                        <!-- Layout 1 ảnh: Phóng to toàn màn hình -->
                        <img src="{{ asset('storage/' . $post->images[0]) }}" class="img-fluid rounded-4 w-100 shadow-sm" alt="{{ $post->title }}">

                    @elseif($imageCount == 2)
                        <!-- Layout 2 ảnh: Chia đôi cột -->
                        <div class="row g-3">
                            @foreach($post->images as $img)
                                <div class="col-6">
                                    <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded-3 w-100 shadow-sm" style="aspect-ratio: 4/3; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>

                    @else
                        <!-- Layout 3-4 ảnh: Grid chuyên nghiệp -->
                        <div class="row g-3">
                            @foreach(array_slice($post->images, 0, 4) as $img)
                                <div class="col-6">
                                    <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded-3 w-100 shadow-sm" style="aspect-ratio: 16/9; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <!-- 3. Nội dung chi tiết -->
            <article class="post-content fs-5 lh-lg text-dark">
                {{-- Dùng {!! !!} để parse HTML nếu Admin dùng CKEditor, kết hợp nl2br để giữ form xuống dòng --}}
                {!! nl2br(e($post->content)) !!}
            </article>

            <!-- 4. Điều hướng -->
            <hr class="my-5 text-muted">
            <div class="d-flex justify-content-between">
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary fw-semibold">
                    <i class="bi bi-arrow-left me-2"></i> Quay lại danh sách
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
