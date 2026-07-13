@extends('admin.layouts.master')
@section('title', 'Quản lý tin tức')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Danh sách bài viết</h3>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary px-4 shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Thêm bài viết mới
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Ảnh bìa</th>
                        <th>Tiêu đề</th>
                        <th>Trạng thái</th><td class="text-end pe-4"></td>
                        <th>Ngày đăng</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td class="ps-4">
                            @if(!empty($post->images))
                                <img src="{{ asset('storage/' . $post->images[0]) }}" class="rounded" width="60" height="60" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $post->title }}</td>
                        <td>
                            <span class="badge {{ $post->status == 'published' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td>{{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Chưa đăng' }}</td>
                        <td class="text-end pe-4">
                            <!-- Nút Xem bài viết -->
                            <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Xem bài viết">
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Nút Sửa -->
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <!-- Nút Xóa -->
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hành động này không thể hoàn tác. Xác nhận xóa?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Xóa bài viết">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Chưa có bài viết nào được tạo.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Phân trang -->
    <div class="card-footer bg-white border-0 p-3">
        {{ $posts->links() }}
    </div>
</div>
@endsection
