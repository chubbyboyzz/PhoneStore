<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\OrderController;

use App\Http\Controllers\Frontend\HomeController;


// Thêm Controller xử lý Dashboard
// Các Route dành cho Khách (Frontend)

Route::get('/', [HomeController::class, 'index'])->name('home');
 // --- CÁC TRANG NỘI DUNG TĨNH (STATIC PAGES) ---
Route::get('/san-pham/{id}', [HomeController::class, 'show'])->name('product.detail');
Route::view('/gioi-thieu', 'frontend.pages.about')->name('pages.about');
Route::view('/bao-hanh', 'frontend.pages.warranty')->name('pages.warranty');
Route::view('/doi-tra', 'frontend.pages.return')->name('pages.return');
Route::view('/dieu-khoan', 'frontend.pages.terms')->name('pages.terms');




// Nhóm Route phân hệ Admin
Route::prefix('admin')->name('admin.')->group(function () {

    // Route không cần đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route BẮT BUỘC phải đăng nhập mới được vào (Khu vực bảo vệ)
    Route::middleware('auth:admin')->group(function () {

        // Giao việc render View cho DashboardController để file Route "mỏng" nhất có thể
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', AdminUserController::class)->parameters([
        'users' => 'admin' // Ép tham số URL thành {admin} để khớp với Form Request
        ]);

        //logout route
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Order routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

        // 2. Tuyến ĐỘNG (chứa tham số wildcard) phải nằm dưới cùng
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Customer routes
        Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
        Route::put('/customers/{id}/toggle', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('customers.toggle');



    });
});


