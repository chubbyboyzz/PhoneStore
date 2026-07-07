@extends('admin.layouts.master')

@section('title', 'Quản trị viên hệ thống')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Tài khoản Quản trị</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary fw-semibold rounded-3">
        <i class="bi bi-person-plus me-1"></i> Cấp tài khoản mới
    </a>
</div>

<!-- Khối hiển thị cảnh báo (Flash Messages) -->
@if (session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
        <i class="bi bi-shield-x me-2"></i> {{ session('error') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4">Họ và tên</th>
                        <th class="py-3">Email đăng nhập</th>
                        <th class="py-3 text-center">Cấp bậc (Role)</th>
                        <th class="py-3 text-center">Trạng thái</th>
                        <th class="py-3 text-center pe-4" style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php /** @var \App\Models\Admin $item */ @endphp
                    @forelse($admins as $item)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $item->name }}
                            @if(auth('admin')->id() == $item->id)
                                <span class="badge bg-primary ms-2 rounded-pill" style="font-size: 0.7rem;">Bạn</span>
                            @endif
                        </td>
                        <td class="text-secondary">{{ $item->email }}</td>
                        <td class="text-center">
                            @if($item->role === 'superadmin')
                                <span class="badge bg-danger rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-star-fill me-1"></i> Super Admin
                                </span>
                            @elseif($item->role === 'manager')
                                <span class="badge bg-primary rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-person-badge me-1"></i> Manager
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-person me-1"></i> Sales
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->is_active)
                                <span class="badge bg-success rounded-pill px-3">Đang hoạt động</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3">Bị khóa</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Thu hồi quyền" onclick="return confirm('Chắc chắn thu hồi tài khoản này?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Chưa có dữ liệu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
