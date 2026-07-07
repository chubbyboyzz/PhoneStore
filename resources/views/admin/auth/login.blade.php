<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Quản trị - PhoneStore</title>
    <!-- Tích hợp Bootstrap 5 CDN cho tốc độ phát triển nhanh -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 fw-bold text-primary">PhoneStore Admin</h3>

                    <!-- Hiển thị thông báo lỗi chung nếu có -->
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.login.post') }}" method="POST">
                        <!-- Cực kỳ quan trọng: Token chống tấn công CSRF -->
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ Email</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light" value="{{ old('email') }}" required autofocus placeholder="admin@phonestore.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light" required placeholder="••••••••">
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3">
                                ĐĂNG NHẬP HỆ THỐNG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-3 mb-0">&copy; {{ date('Y') }} PhoneStore. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</div>

</body>
</html>
