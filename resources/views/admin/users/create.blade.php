@extends('admin.layouts.master')

@section('title', 'Cấp tài khoản Quản trị')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Thêm Quản trị viên</h3>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3">
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
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email đăng nhập <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@phonestore.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cấp bậc (Role) <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <!-- Chỉ hiển thị Option Super Admin nếu người đang đăng nhập là Super Admin -->
                            @if(auth('admin')->user()->role === 'superadmin')
                                <option value="superadmin">Super Admin (Toàn quyền)</option>
                            @endif

                            <option value="manager" selected>Manager (Quản lý cấp trung)</option>
                            <option value="sales">Sales (Nhân viên kinh doanh)</option>
                        </select>
                    </div>

                    <div class="mb-4 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                        <label class="form-check-label fw-semibold" for="isActive">Kích hoạt tài khoản</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary fw-bold py-2 rounded-3">
                            <i class="bi bi-person-check me-1"></i> KHỞI TẠO TÀI KHOẢN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
