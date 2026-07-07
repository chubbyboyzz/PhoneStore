<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController; // Đã thêm Import cho Customer

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\AccountController;


// ==========================================
// PHÂN HỆ FRONTEND (KHÁCH HÀNG)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/san-pham/{id}', [HomeController::class, 'show'])->name('product.detail');
Route::view('/gioi-thieu', 'frontend.pages.about')->name('pages.about');
Route::view('/bao-hanh', 'frontend.pages.warranty')->name('pages.warranty');
Route::view('/doi-tra', 'frontend.pages.return')->name('pages.return');
Route::view('/dieu-khoan', 'frontend.pages.terms')->name('pages.terms');
Route::post('/khach-hang/login', [FrontendAuthController::class, 'login'])->name('frontend.login');
Route::post('/khach-hang/logout', [FrontendAuthController::class, 'logout'])->name('frontend.logout');
Route::post('/khach-hang/register', [FrontendAuthController::class, 'register'])->name('frontend.register');
Route::middleware('auth')->group(function () {
    // Trang danh sách đơn hàng
    Route::get('/tai-khoan/don-hang', [AccountController::class, 'myOrders'])->name('frontend.account.orders');
    // Trang Thông tin cá nhân
    Route::get('/tai-khoan/thong-tin', [AccountController::class, 'profile'])->name('frontend.account.profile');
    Route::put('/tai-khoan/thong-tin', [AccountController::class, 'updateProfile'])->name('frontend.account.update_profile');
    // Route::get('/tai-khoan/don-hang/{id}', [AccountController::class, 'orderDetail'])->name('frontend.account.order_detail');
});

// ==========================================
// PHÂN HỆ ADMIN (QUẢN TRỊ VIÊN)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {

    // 1. Route không cần đăng nhập (Trang Login)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // 2. Route BẮT BUỘC phải đăng nhập (Khu vực bảo vệ)
    Route::middleware('auth:admin')->group(function () {

        // Logout (Chỉ giữ 1 cái ở trong này là chuẩn)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Quản lý Sản phẩm, Danh mục, Admin Users
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', AdminUserController::class)->parameters([
            'users' => 'admin' // Ép tham số URL thành {admin}
        ]);

        // Quản lý Đơn hàng (Orders)
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Quản lý Khách hàng sỉ (Customers) - Đã SỬA LỖI LỒNG PREFIX
        Route::put('/customers/{id}/toggle', [CustomerController::class, 'toggle'])->name('customers.toggle');
        Route::resource('customers', CustomerController::class);

    });
});
