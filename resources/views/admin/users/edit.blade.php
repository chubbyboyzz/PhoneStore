@extends('admin.layouts.master')

@section('title', 'Cập nhật Quản trị viên')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Sửa tài khoản: {{ $adminUser->name ?? 'Không xác định' }}</h3>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3 shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
</div>

<!-- Khối hiển thị lỗi Validation từ StoreAdminRequest -->
@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
        <ul class="mb-0 fw-semibold">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <!-- Chú ý @method('PUT') để giả lập giao thức HTTP PUT chuẩn RESTful -->
        <form action="{{ route('admin.users.update', $adminUser->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Section 1: Thông tin định danh -->
            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-lines-fill me-2"></i>Thông tin cơ bản</h6>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $adminUser->name) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email đăng nhập <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $adminUser->email) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Cấp bậc (Role) <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <!-- Thuật toán ẩn giấu quyền: Chỉ Super Admin mới có thể phân quyền Super Admin -->
                        @if(auth('admin')->user()->role === 'superadmin')
                            <option value="superadmin" {{ $adminUser->role === 'superadmin' ? 'selected' : '' }}>Super Admin (Toàn quyền)</option>
                        @endif
                        <option value="manager" {{ $adminUser->role === 'manager' ? 'selected' : '' }}>Manager (Quản lý cấp trung)</option>
                        <option value="sales" {{ $adminUser->role === 'sales' ? 'selected' : '' }}>Sales (Nhân viên kinh doanh)</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $adminUser->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Kích hoạt tài khoản</label>
                    </div>
                </div>
            </div>

            <hr class="text-muted opacity-25">

            <!-- Section 2: Thông tin bảo mật -->
            <h6 class="fw-bold text-danger mb-3"><i class="bi bi-shield-lock-fill me-2"></i>Thiết lập Bảo mật (Bỏ trống nếu không đổi mật khẩu)</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control" placeholder="Để trống nếu không muốn thay đổi">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-warning fw-bold py-3 rounded-3 text-dark shadow-sm">
                    <i class="bi bi-save-fill me-2"></i> LƯU THAY ĐỔI
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
