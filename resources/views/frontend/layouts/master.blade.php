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
                <ul class="navbar-nav me-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold px-4 bg-danger text-nowrap" href="{{ route('home') }}">
                            <i class="bi bi-grid-fill me-1"></i> TRANG CHỦ
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">ĐIỆN THOẠI THÔNG MINH</a>
                        <ul class="dropdown-menu"><li><a class="dropdown-item fw-medium" href="#">Apple iPhone</a></li></ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">ĐỒNG HỒ THÔNG MINH</a>
                        <ul class="dropdown-menu"><li><a class="dropdown-item fw-medium" href="#">Apple Watch</a></li></ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">MÁY TÍNH BẢNG</a>
                        <ul class="dropdown-menu"><li><a class="dropdown-item fw-medium" href="#">iPad</a></li></ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">PHỤ KIỆN</a>
                        <ul class="dropdown-menu"><li><a class="dropdown-item fw-medium" href="#">Cáp sạc, tai nghe</a></li></ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i> THÊM</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-medium" href="#">Chính sách bảo hành</a></li>
                            <li><a class="dropdown-item fw-medium" href="#">Quy định đổi trả</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center pb-2 pb-lg-0">
                    @auth
                        <li class="nav-item me-lg-3 mt-2 mt-lg-0">
                            <a href="{{ route('frontend.cart.index') }}" class="btn btn-outline-light position-relative border-0" style="padding: 8px 12px;" title="Xem giỏ hàng">
                                <i class="bi bi-cart3 fs-5"></i>
                                @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item ms-lg-3 d-flex align-items-center mt-2 mt-lg-0">
                            <button type="button" class="btn btn-danger fw-bold shadow-sm rounded-pill px-4 py-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-person-circle me-1"></i> Đăng nhập
                            </button>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-3 d-flex align-items-center mt-2 mt-lg-0">
                            <a class="nav-link dropdown-toggle text-white fw-bold px-4 py-2 bg-danger rounded-pill shadow-sm text-nowrap" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-check-fill me-1"></i> Chào, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <li>
                                    <a class="dropdown-item fw-medium py-2" href="{{ route('frontend.account.orders') }}">
                                        <i class="bi bi-bag-check me-2 text-muted"></i> Đơn hàng của tôi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item fw-medium py-2" href="{{ route('frontend.account.profile') }}">
                                        <i class="bi bi-person-gear me-2 text-muted"></i> Thông tin cá nhân
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
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

    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container text-center">
            <p class="mb-1 fw-medium">&copy; {{ date('Y') }} Nam Khuê Corporation. Tất cả quyền được bảo lưu.</p>
            <p class="small text-muted mb-0">Hệ thống phân phối sỉ phụ kiện điện thoại toàn quốc.</p>
        </div>
    </footer>

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

                        <div class="text-center">
                            <span class="text-muted small">Chưa có tài khoản đại lý?</span>
                            <a href="#" class="text-danger small fw-bold text-decoration-none ms-1" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký ngay</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark fs-4"><i class="bi bi-person-plus-fill text-danger me-2"></i>Đăng ký đại lý sỉ mới</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('frontend.register') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Họ tên người liên hệ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control bg-light shadow-none" required value="{{ old('name') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Email đăng nhập <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control bg-light shadow-none" required value="{{ old('email') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Mật khẩu (Tối thiểu 6 số) <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control bg-light shadow-none" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control bg-light shadow-none" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Số điện thoại nhận báo giá</label>
                                    <input type="text" name="phone" class="form-control bg-light shadow-none" value="{{ old('phone') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Địa chỉ tổng kho của đại lý</label>
                                    <textarea name="address" class="form-control bg-light shadow-none" rows="4">{{ old('address') }}</textarea>
                                </div>
                                <div class="p-3 bg-light rounded-3 border small text-muted mt-4">
                                    <i class="bi bi-info-circle-fill text-danger me-1"></i> Lưu ý: Đăng ký xong hệ thống tự động xét duyệt, ông có thể sử dụng tài khoản này để yêu cầu báo giá.
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-bold py-2 rounded-3 shadow-sm mt-4 mb-3">ĐĂNG KÝ ĐẠI LÝ CHÍNH THỨC</button>

                        <div class="text-center">
                            <span class="text-muted small">Đã có tài khoản?</span>
                            <a href="#" class="text-danger small fw-bold text-decoration-none ms-1" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập tại đây</a>
                        </div>
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
</html>
