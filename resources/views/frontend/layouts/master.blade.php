<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nam Khuê Corporation - Tổng kho phụ kiện')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            /* Bộ nhận diện thương hiệu Nam Khuê */
            --nk-red: #D9001B;
            --nk-black: #1A1A1A;
            --nk-white: #FFFFFF;
            --nk-gray-light: #F8F9FA;
        }

        body {
            background-color: var(--nk-gray-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--nk-black);
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ép Footer luôn nằm dưới cùng */
        }

        /* Header & Navbar */
        .frontend-header { background-color: var(--nk-white); }
        .nk-logo { max-height: 60px; object-fit: contain; }
        .nk-navbar {
            background-color: var(--nk-black);
            border-bottom: 3px solid var(--nk-red);
        }

        /* Hiệu ứng Hover */
        .hover-red { transition: background-color 0.2s ease, color 0.2s ease; }
        .hover-red:hover { background-color: var(--nk-red); color: var(--nk-white) !important; }

        .dropdown:hover .dropdown-menu {
            display: block !important;
            margin-top: 0;
            animation: fadeIn 0.2s ease-in-out;
        }
        .dropdown-menu {
            border: none;
            border-top: 3px solid var(--nk-red);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .dropdown-item:hover {
            background-color: var(--nk-red);
            color: var(--nk-white) !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer Links */
        .footer-links a:hover {
            color: var(--nk-white) !important;
            padding-left: 5px;
        }
        .transition-all { transition: all 0.3s ease; }

        /* CSS Trang tĩnh */
        .page-header { background: linear-gradient(180deg, #F8F9FA 0%, #FFFFFF 100%); }
        .static-content-card { transition: transform 0.3s ease; }
        .content-body h5 { letter-spacing: 0.5px; font-weight: 700; }
        .content-body p { font-size: 1.05rem; text-align: justify; }

        /* List dấu tích */
        .custom-list { list-style: none; padding-left: 0; }
        .custom-list li { position: relative; padding-left: 30px; margin-bottom: 15px; font-size: 1.05rem; }
        .custom-list li::before {
            content: '\F26A';
            font-family: 'bootstrap-icons';
            position: absolute;
            left: 0;
            top: 2px;
            color: var(--nk-red);
            font-size: 1.2rem;
        }

        /* Floating Action Buttons */
        .floating-action-group {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 9999;
        }
        .fab-btn {
            display: flex; align-items: center; justify-content: center;
            gap: 8px; padding: 10px 20px; border-radius: 50px;
            color: var(--nk-white) !important; text-decoration: none;
            font-weight: 700; font-size: 0.95rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .fab-btn:hover { transform: translateY(-4px); box-shadow: 0 6px 15px rgba(0,0,0,0.3); }

        .fab-black { background-color: var(--nk-black); }
        .fab-red { background-color: var(--nk-red); }
        .fab-zalo { background-color: #0068FF; }
        .fab-fb { background-color: #0084FF; }
        .fab-btn i { font-size: 1.2rem; }

        /* Nút Lên đầu trang */
        #backToTop { opacity: 0; visibility: hidden; transform: translateY(20px); }
        #backToTop.show { opacity: 1; visibility: visible; transform: translateY(0); }
    </style>

    @stack('styles')

</head>
<body>

    <header class="frontend-header py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-namkhue.png') }}" alt="Nam Khuê Corporation" class="nk-logo" onerror="this.src='https://via.placeholder.com/200x60?text=Logo+Nam+Khue'">
            </a>
            <div class="contact-info d-none d-md-block text-end">
                <small class="text-muted d-block fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Hotline hỗ trợ khách sỉ</small>
                <a href="tel:090xxxxxxx" class="text-decoration-none fw-bolder fs-4" style="color: var(--nk-red);">
                    <i class="bi bi-telephone-fill me-1"></i> 090.xxx.xxxx
                </a>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg sticky-top shadow-sm nk-navbar py-0">
        <div class="container">
            <button class="navbar-toggler border-0 shadow-none text-white py-2" type="button" data-bs-toggle="collapse" data-bs-target="#categoryNav">
                <span class="d-flex align-items-center fw-bold text-uppercase">
                    <i class="bi bi-list fs-2 me-2"></i> Danh mục
                </span>
            </button>

            <div class="collapse navbar-collapse" id="categoryNav">
                <ul class="navbar-nav w-100">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold text-uppercase px-4 py-3 border-end border-secondary border-opacity-25 hover-red {{ request()->routeIs('home') ? 'bg-danger' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-grid-fill me-2"></i> Trang Chủ
                        </a>
                    </li>

                    @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories as $item)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-semibold text-uppercase px-4 py-3 border-end border-secondary border-opacity-25 hover-red"
                               href="{{ route('home', ['category' => $item->id]) }}">
                                {{ $item->name }}
                            </a>
                            @if($item->brands->count() > 0)
                            <ul class="dropdown-menu bg-white rounded-0 py-2 m-0">
                                @foreach($item->brands as $brand)
                                <li>
                                    <a class="dropdown-item fw-medium py-2" href="{{ route('home', ['category' => $item->id, 'brand' => $brand->id]) }}">
                                        {{ $brand->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    @endif

                    <li class="nav-item dropdown ms-auto">
                        <a class="nav-link dropdown-toggle text-white fw-bold text-uppercase px-4 py-3 border-start border-secondary border-opacity-25 hover-red" href="#">
                            <i class="bi bi-three-dots me-1"></i> Thêm
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-white rounded-0 py-2 m-0 shadow-sm border-0 border-top border-3 border-danger">
                            <li><a class="dropdown-item fw-medium py-2" href="{{ route('pages.about') }}"><i class="bi bi-info-circle me-2 text-muted"></i> Về chúng tôi</a></li>
                            <li><a class="dropdown-item fw-medium py-2" href="{{ route('pages.warranty') }}"><i class="bi bi-shield-check me-2 text-muted"></i> Chính sách bảo hành</a></li>
                            <li><a class="dropdown-item fw-medium py-2" href="{{ route('pages.return') }}"><i class="bi bi-arrow-counterclockwise me-2 text-muted"></i> Chính sách đổi trả</a></li>
                            <li><a class="dropdown-item fw-medium py-2" href="{{ route('pages.terms') }}"><i class="bi bi-file-earmark-text me-2 text-muted"></i> Điều khoản sử dụng</a></li>
                        </ul>
                    </li>
                    @guest
                        <li class="nav-item ms-3 d-flex align-items-center">
                            <button type="button" class="btn btn-danger fw-bold shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-person-circle me-1"></i> Đăng nhập
                            </button>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-3 d-flex align-items-center">
                            <a class="nav-link dropdown-toggle text-white fw-bold px-3 py-2 bg-danger rounded-pill shadow-sm" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-check-fill me-1"></i> Chào, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <li>
                                    <a class="dropdown-item fw-medium py-2" href="{{ route('frontend.account.orders') }}">
                                        <i class="bi bi-bag-check me-2 text-muted"></i>Đơn hàng của tôi
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('frontend.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item fw-medium text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="bg-dark text-white py-5 mt-5 border-top border-danger border-3">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5 col-md-12 mb-4 mb-lg-0">
                    <h5 class="fw-bold text-uppercase mb-3" style="color: var(--nk-red);">Nam Khuê Corporation</h5>
                    <p class="text-white-50 mb-2">Hệ thống tổng kho phân phối sỉ phụ kiện điện thoại, thiết bị công nghệ chính hãng hàng đầu khu vực.</p>
                    <ul class="list-unstyled text-white-50 mt-3 lh-lg">
                        <li><i class="bi bi-geo-alt-fill me-2 text-danger"></i> Kho A, Khu công nghiệp ABC, TP.HCM</li>
                        <li><i class="bi bi-telephone-fill me-2 text-danger"></i> Hotline sỉ: 090.xxx.xxxx</li>
                        <li><i class="bi bi-envelope-fill me-2 text-danger"></i> Email: b2b@namkhue.com</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase fw-bold text-white mb-3">Hỗ trợ đối tác</h6>
                    <ul class="list-unstyled footer-links lh-lg">
                        <li><a href="{{ route('pages.about') }}" class="text-white-50 text-decoration-none hover-text-white transition-all"><i class="bi bi-chevron-right small me-1"></i> Về chúng tôi</a></li>
                        <li><a href="{{ route('pages.warranty') }}" class="text-white-50 text-decoration-none hover-text-white transition-all"><i class="bi bi-chevron-right small me-1"></i> Chính sách bảo hành</a></li>
                        <li><a href="{{ route('pages.return') }}" class="text-white-50 text-decoration-none hover-text-white transition-all"><i class="bi bi-chevron-right small me-1"></i> Chính sách đổi trả</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="text-white-50 text-decoration-none hover-text-white transition-all"><i class="bi bi-chevron-right small me-1"></i> Điều khoản sử dụng</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-uppercase fw-bold text-white mb-3">Kết nối với chúng tôi</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light rounded-circle"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="btn btn-outline-light rounded-circle"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-4 opacity-25">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start text-white-50 small">
                    &copy; {{ date('Y') }} Nam Khuê Corporation. All Rights Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end text-white-50 small mt-2 mt-md-0">
                    Hệ thống quản trị nội dung (CMS) B2B
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1090; margin-top: 80px;">
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


    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark fs-4"><i class="bi bi-box-arrow-in-right text-danger me-2"></i>Đăng nhập khách sỉ</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark fs-4"><i class="bi bi-person-plus-fill text-danger me-2"></i>Đăng ký đại lý sỉ mới</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('frontend.register') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Họ tên người liên hệ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control bg-light shadow-none" required value="{{ old('name') }}" placeholder="Ví dụ: Nguyễn Văn A">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Email đăng nhập <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control bg-light shadow-none" required value="{{ old('email') }}" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Mật khẩu (Tối thiểu 6 số) <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control bg-light shadow-none" required placeholder="Tạo mật khẩu...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control bg-light shadow-none" required placeholder="Gõ lại mật khẩu...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Số điện thoại nhận báo giá</label>
                                    <input type="text" name="phone" class="form-control bg-light shadow-none" value="{{ old('phone') }}" placeholder="Số điện thoại di động hoặc Zalo...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Địa chỉ tổng kho của đại lý</label>
                                    <textarea name="address" class="form-control bg-light shadow-none" rows="4" placeholder="Nhập địa chỉ cụ thể để tính toán xe vận chuyển phụ kiện...">{{ old('address') }}</textarea>
                                </div>
                                <div class="p-3 bg-light rounded-3 border small text-muted mt-4">
                                    <i class="bi bi-info-circle-fill text-danger me-1"></i> Lưu ý: Đăng ký xong hệ thống tự động xét duyệt, ông có thể sử dụng tài khoản này để yêu cầu gửi báo giá nhanh qua Zalo OA ngay lập tức.
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy ra tất cả các khối Toast thông báo
            const toasts = document.querySelectorAll('.custom-toast');
            toasts.forEach(function(toast) {
                // Sau 4 giây (4000ms) tự động biến mất mượt mà
                setTimeout(function() {
                    toast.classList.remove('show');
                    setTimeout(function() {
                        toast.remove();
                    }, 300); // Đợi hiệu ứng mờ kết thúc rồi xóa thẻ HTML
                }, 4000);
            });
        });
    </script>

    <div class="floating-action-group">
        <a href="#" id="backToTop" class="fab-btn fab-black" title="Lên đầu trang">
            <span class="fab-text">Lên đầu</span>
            <i class="bi bi-chevron-double-up"></i>
        </a>
        <a href="https://m.me/namkhuecorp" target="_blank" class="fab-btn fab-fb" title="Chat Facebook">
            <span class="fab-text">Facebook</span>
            <i class="bi bi-messenger"></i>
        </a>
        <a href="https://zalo.me/090xxxxxxx" target="_blank" class="fab-btn fab-zalo" title="Chat Zalo">
            <span class="fab-text">Zalo OA</span>
            <i class="bi bi-chat-dots-fill"></i>
        </a>
        <a href="tel:090xxxxxxx" class="fab-btn fab-red" title="Gọi Hotline">
            <span class="fab-text">Liên hệ</span>
            <i class="bi bi-headset"></i>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopBtn = document.getElementById('backToTop');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            });
            backToTopBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
