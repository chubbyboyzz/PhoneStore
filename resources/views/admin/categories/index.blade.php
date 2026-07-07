@extends('admin.layouts.master')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Danh mục Sản phẩm</h3>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary fw-semibold rounded-3">
        <i class="bi bi-plus-lg me-1"></i> Thêm danh mục
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <div class="row mb-3">
                <div class="col-md-6 col-lg-4">
                    <form action="{{ route('admin.categories.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Tìm</button>

                            @if(request()->filled('search'))
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary" title="Xóa tìm kiếm"><i class="bi bi-x-lg"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4" style="width: 60px;">#</th>
                        <th class="py-3">Tên danh mục</th>
                        <th class="py-3">Đường dẫn tĩnh (Slug)</th>
                        <th class="py-3 text-center">Số lượng SP</th>
                        <th class="py-3 text-center">Sắp xếp</th>
                        <th class="py-3 text-center">Trạng thái</th>
                        <th class="py-3 text-center pe-4" style="width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Type Hinting giúp IDE nhận diện cấu trúc Model -->
                    @php /** @var \App\Models\Category $item */ @endphp
                    @forelse($categories as $item)
                    <tr>
                        <td class="ps-4 text-muted fw-semibold">{{ $item->id }}</td>
                        <td class="fw-bold text-dark">{{ $item->name }}</td>
                        <td class="text-secondary">{{ $item->slug }}</td>
                        <td class="text-center">
                            <!-- Gọi biến products_count được sinh ra từ hàm withCount() ở Repository -->
                            <span class="badge bg-info text-dark rounded-pill px-3">{{ $item->products_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $item->sort_order }}</span>
                        </td>
                        <td class="text-center">
                            @if($item->is_active)
                                <span class="badge bg-success rounded-pill px-3">Hiển thị</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3">Đang ẩn</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ route('admin.categories.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Xóa" onclick="return confirm('Chắc chắn xóa danh mục này? Lưu ý: Việc xóa có thể ảnh hưởng đến sản phẩm bên trong.')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-tags fs-1 d-block mb-2 opacity-50"></i> Chưa có danh mục nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $categories->links() }}
    </div>
</div>
@endsection
