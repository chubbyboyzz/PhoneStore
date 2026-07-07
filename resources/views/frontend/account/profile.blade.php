@extends('frontend.layouts.master')

@section('title', 'Thông tin cá nhân - Nam Khuê Corporation')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="bg-white rounded-4 shadow-sm border border-secondary-subtle overflow-hidden">
                <div class="p-4 bg-dark text-white text-center">
                    <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                    <small class="text-white-50">{{ Auth::user()->phone ?? 'Chưa cập nhật SĐT' }}</small>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('frontend.account.orders') }}" class="list-group-item list-group-item-action py-3 px-4 fw-medium text-secondary">
                        <i class="bi bi-bag-check-fill me-2"></i> Lịch sử đơn hàng
                    </a>
                    <a href="{{ route('frontend.account.profile') }}" class="list-group-item list-group-item-action py-3 px-4 fw-bold text-danger bg-light border-start border-4 border-danger">
                        <i class="bi bi-person-gear me-2"></i> Thông tin cá nhân
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 px-4 fw-medium text-secondary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="bg-white p-4 rounded-4 shadow-sm border border-secondary-subtle h-100">
                <h4 class="fw-bold border-bottom pb-3 mb-4"><i class="bi bi-person-lines-fill text-danger me-2"></i> Cập nhật hồ sơ</h4>

                <form action="{{ route('frontend.account.update_profile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email đăng nhập (Không thể đổi)</label>
                            <input type="email" class="form-control bg-light text-muted" value="{{ $user->email }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số điện thoại liên hệ</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Địa chỉ kho nhận hàng</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}">
                        </div>
                    </div>

                    <h5 class="fw-bold border-bottom pb-2 mb-3 mt-5">Đổi mật khẩu mới</h5>
                    <div class="p-3 bg-light rounded-3 border mb-4 small text-muted">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i> Bỏ trống 2 ô dưới đây nếu ông không muốn thay đổi mật khẩu hiện tại.
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nhập ít nhất 6 ký tự...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới...">
                        </div>
                    </div>

                    <hr class="my-4 text-secondary opacity-25">

                    <div class="text-end">
                        <button type="submit" class="btn btn-danger fw-bold px-4 py-2 shadow-sm"><i class="bi bi-floppy-fill me-1"></i> Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
