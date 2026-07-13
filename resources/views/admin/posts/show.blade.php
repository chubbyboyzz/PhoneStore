@extends('frontend.layouts.master')
@section('title', $post->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Tiêu đề & Ngày tháng -->
            <h1 class="fw-bold mb-3">{{ $post->title }}</h1>
            <p class="text-muted mb-4"><i class="bi bi-clock me-2"></i> {{ $post->created_at->format('d/m/Y H:i') }}</p>

            <!-- Thuật toán hiển thị Layout Ảnh thông minh (Grid Pattern) -->
            @if(is_array($post->images) && count($post->images) > 0)
                <div class="mb-4">
                    @if(count($post->images) == 1)
                        <img src="{{ asset('storage/' . $post->images[0]) }}" class="img-fluid rounded w-100 shadow-sm" alt="{{ $post->title }}">
                    @elseif(count($post->images) == 2)
                        <div class="row g-2">
                            @foreach($post->images as $img)
                                <div class="col-6"><img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded w-100 shadow-sm"></div>
                            @endforeach
                        </div>
                    @else
                        <!-- Nếu có 3 hoặc 4 ảnh, hiển thị dạng Grid 2x2 chuyên nghiệp -->
                        <div class="row g-2">
                            @foreach(array_slice($post->images, 0, 4) as $img)
                                <div class="col-6"><img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded w-100 shadow-sm" style="aspect-ratio: 4/3; object-fit: cover;"></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <!-- Nội dung bài viết -->
            <div class="post-content fs-5 lh-lg text-dark">
                {!! nl2br(e($post->content)) !!}
            </div>

            <hr class="my-5">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">&larr; Quay lại danh sách tin</a>
        </div>
    </div>
</div>
@endsection
