<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    //Logic xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Chống lỗi session fixation
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logic xử lý đăng xuất
    public function logout(Request $request)
    {
        // 1. Hủy xác thực tài khoản khỏi Guard 'admin'
        Auth::guard('admin')->logout();

        // 2. Vô hiệu hóa và xóa sạch toàn bộ Session Data trên Server
        $request->session()->invalidate();

        // 3. Tái tạo CSRF Token mới để chống lại các cuộc tấn công giả mạo phiên
        $request->session()->regenerateToken();

        // 4. Điều hướng về trang Đăng nhập kèm cờ thông báo
        return redirect()->route('admin.login')
                         ->with('success', 'Bạn đã đăng xuất khỏi hệ thống an toàn.');
    }

}
