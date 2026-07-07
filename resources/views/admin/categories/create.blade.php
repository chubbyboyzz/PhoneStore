@extends('admin.layouts.master')

@section('title', 'Thêm mới Danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Thêm mới Danh mục</h3>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ví dụ: Điện thoại, Laptop..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thứ tự sắp xếp</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                        <small class="text-muted">Số càng nhỏ, danh mục hiển thị càng ưu tiên lên đầu.</small>
                    </div>

                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                        <label class="form-check-label fw-semibold" for="isActive">Hiển thị danh mục</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary fw-bold py-2 rounded-3">
                            <i class="bi bi-save me-1"></i> LƯU DANH MỤC
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
