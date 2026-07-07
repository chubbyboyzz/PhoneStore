<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - PhoneStore</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
    :root {
        /* Tông màu Đen chủ đạo */
        --bs-dark: #1a1d20;
        --bs-dark-rgb: 26, 29, 32;

        /* Tông màu Đỏ làm điểm nhấn (Accent Color) */
        --bs-danger: #d90429;
        --bs-danger-rgb: 217, 4, 41;

        /* Tùy biến nút Primary thành màu Đỏ khách hàng */
        --bs-primary: #ef233c;
        --bs-primary-rgb: 239, 35, 60;
    }

    /* ĐỒNG BỘ CSS SELECTOR: Đổi từ .sidebar thành #sidebar để khớp với ID của HTML */
    #sidebar {
        background-color: var(--bs-dark);
        color: #ffffff;
        box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        min-height: 100vh; /* Thuật toán UI: Đảm bảo sidebar luôn dài hết chiều cao màn hình */
        width: 250px; /* Cố định chiều rộng */
    }

    /* Xử lý trạng thái tĩnh: Ép màu đỏ chủ đạo cho chữ và icon */
    #sidebar .nav-link,
    #sidebar .nav-link i {
        color: var(--bs-danger) !important; /* Dùng !important để vô hiệu hóa màu xanh mặc định của Bootstrap */
        font-weight: 500;
        transition: all 0.3s ease-in-out;
    }

    /* Xử lý trạng thái tương tác (Hover & Active): Đảo ngược nền đỏ - chữ trắng */
    #sidebar .nav-link:hover,
    #sidebar .nav-link.active,
    #sidebar .nav-link:hover i,
    #sidebar .nav-link.active i {
        color: #ffffff !important;
        background-color: var(--bs-danger);
        border-radius: 0.375rem;
        box-shadow: 0 4px 8px rgba(217, 4, 41, 0.25);
    }

    /* Đồng bộ viền và các thành phần nút bấm cốt lõi */
    .btn-primary {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
    .btn-primary:hover {
        background-color: var(--bs-danger);
        border-color: var(--bs-danger);
    }

    /* Hiệu ứng focus input form thông minh */
    .form-control:focus, .form-select:focus {
        border-color: var(--bs-danger);
        box-shadow: 0 0 0 0.25rem rgba(217, 4, 41, 0.25);
    }

    .text-dark {
        color: var(--bs-dark) !important;
    }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    <!-- SIDEBAR -->
    <!-- Đã giữ nguyên id="sidebar" để khớp với thuật toán CSS bên trên -->
    <div id="sidebar" class="bg-dark text-white shadow-sm flex-shrink-0">
        <div class="p-4 text-center border-bottom border-secondary">
            <!-- Đổi class text-primary thành text-danger để logo đồng bộ màu Đỏ -->
            <h4 class="fw-bold mb-0 text-danger">
                <i class="bi bi-phone"></i> PhoneStore
            </h4>
            <small class="text-white-50" style="letter-spacing: 1px;">Quản trị hệ thống</small>
        </div>

        <ul class="nav flex-column mt-3 px-2">
            <li class="nav-item mb-1">
                <a class="nav-link active py-3" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link py-3 {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam me-3 fs-5"></i> Sản phẩm
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link py-3 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags me-3 fs-5"></i> Danh mục
                </a>
            </li>
            <li class="nav-item mb-1">
                <a class="nav-link py-3 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-cart-check me-3 fs-5"></i> Đơn hàng
                </a>
            </li>
           <li class="nav-item mb-1">
                <a class="nav-link py-3 {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                    <i class="bi bi-people me-3 fs-5"></i> Khách hàng
                </a>
            </li>

            <!-- Dải phân cách module Phân quyền -->
            <li class="nav-item mt-4 mb-2">
                <!-- Cập nhật: Đổi text-muted thành text-danger để nổi bật phân khu chức năng -->
                <h6 class="ps-3 text-danger text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
                    Bảo mật & Phân quyền
                </h6>
            </li>

            <!-- Menu Tài khoản Quản trị -->
            <li class="nav-item mb-1">
                <a class="nav-link py-3 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-shield-lock me-3 fs-5"></i> Quản trị viên
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="w-100 d-flex flex-column" style="min-height: 100vh;">
        <!-- HEADER -->
        <nav class="navbar navbar-expand bg-white shadow-sm px-4 py-3">
            <div class="ms-auto d-flex align-items-center">
                <span class="me-4 fw-semibold text-secondary">
                    Xin chào, <span class="text-dark">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                </span>
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <!-- Cập nhật nút đăng xuất thành màu Đỏ khách hàng -->
                    <button type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-bold">
                        <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </nav>

        <!-- CONTENT AREA -->
        <div class="container-fluid p-4 overflow-auto">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
