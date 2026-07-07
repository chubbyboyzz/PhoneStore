@extends('admin.layouts.master')

@section('title', 'Tạo Đơn Hàng Mới')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-plus-circle-fill me-2 text-danger"></i> Tạo Đơn Hàng</h3>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3 shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<!-- Hiển thị lỗi Validation -->
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
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf

            <h6 class="fw-bold text-danger mb-3"><i class="bi bi-person-badge-fill me-2"></i>Thông tin Khách hàng (Bắt buộc)</h6>
            <div class="row mb-4">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Chọn Khách hàng <span class="text-danger">*</span></label>
                    <select name="user_id" class="form-select" required>
                        <option value="" disabled selected>-- Chọn tài khoản khách hàng --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->phone ?? 'Không có SĐT' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr class="text-muted opacity-25">

            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-receipt me-2"></i>Thông số Giao dịch cơ bản</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tổng tiền (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="total_price" class="form-control" value="{{ old('total_price', 0) }}" min="0" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Trạng thái khởi tạo <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="1" selected>Chờ xác nhận (Pending)</option>
                        <option value="2">Đang xử lý (Processing)</option>
                    </select>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-danger fw-bold py-3 rounded-3 text-white shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i> XÁC NHẬN TẠO ĐƠN
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
