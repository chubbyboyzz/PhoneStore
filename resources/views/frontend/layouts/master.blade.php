<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nam Khuê Corporation - Tổng kho sỉ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --nk-red: #d9001b;
            --nk-black: #1a1a1a;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        .text-danger { color: var(--nk-red) !important; }
        .bg-danger { background-color: var(--nk-red) !important; }
        .btn-danger { background-color: var(--nk-red); border-color: var(--nk-red); }
        .btn-danger:hover { background-color: #b30015; border-color: #b30015; }

        /* Custom Navbar */
        .navbar-dark .nav-link {
            color: #ffffff;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 600;
            padding: 16px 20px !important;
        }
        .navbar-dark .nav-link:hover { color: #f8d7da; }
        .dropdown-menu { border-radius: 8px; border: 1px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }


    .custom-multi-level .dropend {
        position: relative;
    }

    .custom-multi-level .dropend > .submenu {
        display: none;
        position: absolute;
        top: 0;
        left: 100%; /* Bắt đầu ngay từ mép phải */
        min-width: 200px;
        margin-left: 0; /* BỎ margin để tránh lỗi hụt chuột */
        z-index: 1050; /* Đảm bảo đè lên mọi nội dung bên dưới */
        border-radius: 8px;
    }

    /* KỸ THUẬT: Cầu nối vô hình giữ event Hover */
    .custom-multi-level .dropend > .submenu::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: -15px; /* Quét một vùng an toàn 15px bên trái */
        width: 15px;
        background: transparent;
    }

    /* Hiệu ứng hiển thị (Ép !important để đè core Bootstrap) */
    @media (min-width: 992px) {
        .custom-multi-level .dropend:hover > .submenu {
            display: block !important;
            animation: slideIn 0.2s cubic-bezier(0.25, 0.8, 0.25, 1) forwards;
        }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-5px); }
        to { opacity: 1; transform: translateX(0); }
    }
    </style>
    @stack('styles')
</head>
<body>

    <div class="bg-white py-3 border-bottom">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-namkhue.png') }}" alt="Nam Khuê Corporation" style="height: 50px;">
            </a>
            <div class="text-end">
                <div class="text-muted small fw-bold">HOTLINE HỖ TRỢ KHÁCH SỈ</div>
                <div class="text-danger fw-bolder fs-4"><i class="bi bi-telephone-fill me-1"></i> 0862.542.394</div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top p-0" style="background-color: var(--nk-black); box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="container">
            <button class="navbar-toggler my-2 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainMenu">

                <!-- KHU VỰC 1: ĐIỀU HƯỚNG CHÍNH (MAIN MENU) -->
                <ul class="navbar-nav me-auto align-items-center">

                    <!-- 1. Trang chủ -->
                    <li class="nav-item">
                        <a class="nav-link fw-bold px-4 text-nowrap {{ request()->routeIs('home') && !request()->has('category') ? 'bg-danger text-white' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door-fill me-1"></i> TRANG CHỦ
                        </a>
                    </li>

                    <!-- 2. Các sản phẩm (Dropdown Danh mục) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold px-4 {{ request()->has('category') || request()->routeIs('product.detail') ? 'bg-danger text-white' : '' }}" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-box-seam-fill me-1"></i> CÁC SẢN PHẨM
                        </a>

                        <ul class="dropdown-menu shadow-sm border-0 mt-2 custom-multi-level">
                            <!-- Duyệt qua các Danh mục -->
                            @forelse($globalCategories as $category)
                                <li class="{{ $category->brands->isNotEmpty() ? 'dropend' : '' }}">

                                    <!-- Link của Danh mục gốc -->
                                    <a class="dropdown-item fw-medium py-2 d-flex justify-content-between align-items-center" href="{{ route('home', ['category' => $category->slug]) }}">
                                        {{ $category->name }}
                                        @if($category->brands->isNotEmpty())
                                            <i class="bi bi-chevron-right small text-muted"></i>
                                        @endif
                                    </a>

                                    <!-- Render Submenu Thương hiệu (Brands) nếu tồn tại -->
                                    @if($category->brands->isNotEmpty())
                                        <ul class="dropdown-menu submenu border-0 shadow-sm mt-0">
                                            @foreach($category->brands as $brand)
                                                <li>
                                                    <!-- Thuật toán Cross-Filtering: Truyền đồng thời cả category slug và brand id -->
                                                    <a class="dropdown-item py-2 text-secondary" href="{{ route('home', ['category' => $category->slug, 'brand' => $brand->id]) }}">
                                                        {{ $brand->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @empty
                                <li><span class="dropdown-item fw-medium py-2 text-muted fst-italic">Đang cập nhật danh mục...</span></li>
                            @endforelse

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item fw-bold text-danger py-2" href="{{ route('home') }}">
                                    <i class="bi bi-grid-fill me-1"></i> Xem tất cả sản phẩm
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 3. Tin tức -->
                    <li class="nav-item">
                        <a class="nav-link fw-bold px-4 text-nowrap {{ request()->routeIs('posts.*') ? 'bg-danger text-white' : '' }}" href="{{ route('posts.index') }}">
                            <i class="bi bi-newspaper me-1"></i> TIN TỨC
                        </a>
                    </li>

                    <!-- 4. Giới thiệu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold px-4 {{ request()->routeIs('pages.*') ? 'bg-danger text-white' : '' }}" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-info-circle-fill me-1"></i> GIỚI THIỆU
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0 mt-2">
                            <li><a class="dropdown-item fw-medium py-2" href="{{ route('pages.about') }}">Về Nam Khuê Corporation</a></li>
                            <li><a class="dropdown-item fw-medium py-2" href="{{ route('pages.return') }}">Chính sách đổi trả</a></li>
                            <li><a class="dropdown-item fw-bold text-danger py-2" href="{{ route('pages.terms') }}">Điều khoản & Chính sách</a></li>
                            <li><a class="dropdown-item fw-bold text-danger py-2" href="{{ route('pages.warranty') }}">Chính sách bảo hành</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- KHU VỰC 2: TIỆN ÍCH NGƯỜI DÙNG (TÀI KHOẢN & GIỎ HÀNG) -->
                <ul class="navbar-nav align-items-center pb-2 pb-lg-0">
                    <!-- Nút Giỏ hàng (Đã cập nhật route chuẩn) -->
                    @auth
                        <li class="nav-item me-lg-3 mt-2 mt-lg-0">
                            <a href="{{ route('frontend.cart.index') }}" class="btn btn-outline-light position-relative border-0" style="padding: 8px 12px;" title="Xem giỏ hàng">
                                <i class="bi bi-cart3 fs-5"></i>
                                @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light shadow-sm">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endauth

                    <!-- Khu vực Tài khoản (Authentication State) -->
                    @guest
                        <li class="nav-item ms-lg-3 d-flex align-items-center mt-2 mt-lg-0">
                            <button type="button" class="btn btn-danger fw-bold shadow-sm rounded-pill px-4 py-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-person-circle me-1"></i> Đăng nhập
                            </button>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-3 d-flex align-items-center mt-2 mt-lg-0">
                            <a class="nav-link dropdown-toggle text-white fw-bold px-4 py-2 bg-danger rounded-pill shadow-sm text-nowrap" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-check-fill me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <!-- Đã cập nhật route về account.index theo thiết kế mới -->
                                <li>
                                    <a class="dropdown-item fw-medium py-2" href="{{ route('frontend.account.profile') }}">
                                        <i class="bi bi-person-gear me-2 text-muted"></i> Quản lý tài khoản
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <!-- Chú ý: Route đăng xuất cần giữ nguyên cấu trúc POST để bảo mật -->
                                    <form action="{{ route('frontend.logout') }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item fw-medium text-danger py-2 w-100 text-start border-0 bg-transparent">
                                            <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main style="min-height: 60vh;">
        @yield('content')
    </main>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 80px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-lg rounded-4 p-3 mb-2 custom-toast" role="alert" style="min-width: 320px;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-3 me-3 text-success"></i>
                    <div>
                        <strong class="text-dark d-block mb-1">Thành công!</strong>
                        <span class="text-secondary small">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-lg rounded-4 p-3 mb-2 custom-toast" role="alert" style="min-width: 320px;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-danger"></i>
                    <div>
                        <strong class="text-dark d-block mb-1">Thất bại!</strong>
                        <span class="text-secondary small">{{ session('error') }}</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-lg rounded-4 p-3 mb-2 custom-toast" role="alert" style="min-width: 320px;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-x-circle-fill fs-3 me-3 text-danger"></i>
                    <div>
                        <strong class="text-dark d-block mb-1">Lỗi dữ liệu!</strong>
                        <ul class="mb-0 ps-3 small text-secondary">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    @guest
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark fs-4"><i class="bi bi-box-arrow-in-right text-danger me-2"></i>Đăng nhập khách sỉ</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('frontend.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email tài khoản</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0 bg-light shadow-none" required placeholder="Nhập email đại lý...">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0 bg-light shadow-none" required placeholder="••••••••">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-bold py-2 rounded-3 shadow-sm mb-3">ĐĂNG NHẬP HỆ THỐNG</button>
                         <a href="#" class="text-danger fw-bold small text-decoration-none ms-1" onclick="document.getElementById('register-tab').click(); return false;">
                                    Đăng ký ngay
                        </a>
                    </form>

                    <form action="{{ route('frontend.register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Tên Cửa hàng / Đại lý <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control shadow-none" required placeholder="VD: Phụ kiện Quang Thắng">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Số điện thoại Zalo <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control shadow-none" required placeholder="SĐT để nhân viên liên hệ xác minh">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email đăng nhập <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control shadow-none" required placeholder="Email sử dụng để đăng nhập">
                        </div>

                        <!-- KHỐI MẬT KHẨU ĐÃ ĐƯỢC CẤU TRÚC LẠI -->
                        <div class="row gx-2">
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold small">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control shadow-none" required placeholder="Mật khẩu (Tối thiểu 6 ký tự)">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label fw-semibold small">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control shadow-none" required placeholder="Xác nhận lại mật khẩu">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold py-2 rounded-3 shadow-sm text-uppercase">
                            Gửi yêu cầu xét duyệt
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto hide Toasts sau 4 giây
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.custom-toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            });
        });
    </script>
    @stack('scripts')

    <div class="floating-contact-wrapper position-fixed" style="bottom: 30px; right: 30px; z-index: 9999; display: flex; flex-direction: column; gap: 12px; align-items: flex-end;">

        <a href="https://web.facebook.com/NKMobile25" target="_blank" class="btn rounded-pill shadow-lg d-flex align-items-center justify-content-center fw-bold text-white px-4 py-2 floating-btn" style="background-color: #0084FF; border: none;">
            Facebook <i class="bi bi-messenger ms-2"></i>
        </a>

        <a href="https://zalo.me/0862.542.394" target="_blank" class="btn rounded-pill shadow-lg d-flex align-items-center justify-content-center fw-bold text-white px-4 py-2 floating-btn" style="background-color: #0068FF; border: none;">
            Zalo OA <i class="bi bi-chat-dots-fill ms-2"></i>
        </a>

        <a href="tel:0862542394" class="btn btn-danger rounded-pill shadow-lg d-flex align-items-center justify-content-center fw-bold text-white px-4 py-2 floating-btn pulse-hotline">
            Liên hệ <i class="bi bi-headset ms-2"></i>
        </a>

    </div>

    <style>
        /* Hiệu ứng phóng to khi di chuột vào nút */
        .floating-contact-wrapper .floating-btn {
            transition: transform 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .floating-contact-wrapper .floating-btn:hover {
            transform: scale(1.05) translateX(-5px);
        }

        /* Hiệu ứng nhịp đập (Pulse) thu hút sự chú ý cho nút Hotline đỏ */
        .pulse-hotline {
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(217, 0, 27, 0.7); }
            70% { box-shadow: 0 0 0 12px rgba(217, 0, 27, 0); }
            100% { box-shadow: 0 0 0 0 rgba(217, 0, 27, 0); }
        }
    </style>
</body>

<footer class="bg-dark text-light pt-5 mt-5 border-top border-danger border-4">
    <div class="container py-4">
        <div class="row g-4">

            <!-- Cột 1: Thông tin Doanh nghiệp & Pháp lý -->
            <div class="col-lg-4 col-md-6">
                <h5 class="text-uppercase fw-bold text-white mb-4" style="letter-spacing: 1px;">
                    <i class="bi bi-phone text-danger me-2"></i> Nam Khuê Corporation
                </h5>
                <p class="text-white-50 small lh-lg mb-3">
                    Tổng kho phân phối phụ kiện điện thoại. Đối tác cung cấp sỉ/lẻ uy tín hàng đầu với mức giá cạnh tranh nhất thị trường.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="https://web.facebook.com/NKMobile25" class="btn btn-outline-light btn-sm rounded-circle"><i class="bi bi-facebook"></i></a>
                </div>
            </div>

            <!-- Cột 2: Thông tin Liên hệ (Contact) -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold text-white mb-4 border-bottom border-secondary pb-2 d-inline-block">
                    Liên hệ trực tiếp
                </h6>
                <ul class="list-unstyled text-white-50 small lh-lg">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill text-danger me-3 mt-1 fs-6"></i>
                        <span>154 đường Cầu Bươu, Khu đô thị Đại Thanh, Hà Nội</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone-fill text-danger me-3 fs-6"></i>
                        <a href="tel:0862542394" class="text-white-50 text-decoration-none hover-white">0862.542.394 (Hotline/Zalo)</a>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope-fill text-danger me-3 fs-6"></i>
                        <a href="mailto:duccuongnd2305@gmail.com" class="text-white-50 text-decoration-none hover-white">duccuongnd2305@gmail.com</a>
                    </li>
                </ul>
            </div>

            <!-- Cột 3: Liên kết & Chính sách (Tích hợp Route nội bộ) -->
            <div class="col-lg-2 col-md-6">
                <h6 class="text-uppercase fw-bold text-white mb-4 border-bottom border-secondary pb-2 d-inline-block">
                    Chính sách
                </h6>
                <ul class="list-unstyled text-white-50 small lh-lg">
                    <li class="mb-2">
                        <a href="{{ route('pages.about') }}" class="text-white-50 text-decoration-none hover-red transition-all">
                            <i class="bi bi-chevron-right text-danger me-1" style="font-size: 10px;"></i> Về chúng tôi
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('pages.warranty') }}" class="text-white-50 text-decoration-none hover-red transition-all">
                            <i class="bi bi-chevron-right text-danger me-1" style="font-size: 10px;"></i> Chính sách bảo hành
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('pages.return') }}" class="text-white-50 text-decoration-none hover-red transition-all">
                            <i class="bi bi-chevron-right text-danger me-1" style="font-size: 10px;"></i> Quy định đổi trả
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('pages.terms') }}" class="text-white-50 text-decoration-none hover-red transition-all">
                            <i class="bi bi-chevron-right text-danger me-1" style="font-size: 10px;"></i> Điều khoản dịch vụ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Cột 4: Đăng ký nhận báo giá -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold text-white mb-4 border-bottom border-secondary pb-2 d-inline-block">
                    Đăng ký đại lý
                </h6>
                <p class="text-white-50 small mb-3">Nhắn tin cho số điện thoại liên hệ để được tư vấn và đăng ký làm đại lý.</p>
                </form>
                <div class="mt-4">
                    <img src="https://images.dmca.com/Badges/dmca-badge-w100-5x1-10.png?ID=xxxx" alt="DMCA Protected" class="img-fluid opacity-75">
                </div>
            </div>

        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="bg-black py-3 mt-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="text-white-50 small mb-2 mb-md-0">
                &copy; {{ date('Y') }} <strong>Nam Khuê Corporation</strong>. Đã đăng ký bản quyền.
            </div>
            <div class="text-white-50 small">
                Phát triển hệ thống bởi <span class="text-danger fw-semibold">FPT Software Engineering</span>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-white:hover { color: #ffffff !important; }
    .hover-red:hover { color: #d90429 !important; padding-left: 4px; }
    .transition-all { transition: all 0.3s ease; }
</style>
</html>
