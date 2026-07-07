@extends('admin.layouts.master')

@section('title', 'Thêm Khách hàng mới')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-person-plus-fill me-2 text-danger"></i> Thêm Khách hàng</h3>
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary fw-bold shadow-sm"><i class="bi bi-arrow-left me-1"></i> Quay lại</a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="fw-bold text-danger mb-3 border-bottom pb-2">Thông tin đăng nhập</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="fw-bold text-danger mb-3 border-bottom pb-2">Thông tin liên hệ</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Địa chỉ giao hàng</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Trạng thái tài khoản</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Hoạt động bình thường</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Khóa tài khoản</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-4 text-secondary">

            <div class="text-end">
                <button type="reset" class="btn btn-light fw-bold me-2 border">Nhập lại</button>
                <button type="submit" class="btn btn-danger fw-bold shadow-sm"><i class="bi bi-floppy-fill me-1"></i> Lưu thông tin</button>
            </div>
        </form>
    </div>
</div>
@endsection
