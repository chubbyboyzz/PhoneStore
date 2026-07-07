@extends('admin.layouts.master')

@section('title', 'Cập nhật Khách hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-danger"></i> Cập nhật Khách hàng</h3>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary fw-bold shadow-sm"><i class="bi bi-arrow-left me-1"></i> Quay lại</a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="fw-bold text-danger mb-3 border-bottom pb-2">Thông tin đăng nhập</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Đổi mật khẩu mới</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Bỏ trống nếu không muốn đổi mật khẩu">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="fw-bold text-danger mb-3 border-bottom pb-2">Thông tin liên hệ</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Địa chỉ giao hàng</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $customer->address) }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Trạng thái tài khoản</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $customer->is_active) == '1' ? 'selected' : '' }}>Hoạt động bình thường</option>
                            <option value="0" {{ old('is_active', $customer->is_active) == '0' ? 'selected' : '' }}>Khóa tài khoản</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-4 text-secondary">

            <div class="text-end">
                <button type="submit" class="btn btn-primary fw-bold shadow-sm"><i class="bi bi-floppy-fill me-1"></i> Cập nhật thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection
