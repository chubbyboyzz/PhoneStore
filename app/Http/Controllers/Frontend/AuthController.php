<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Xử lý Đăng nhập Khách hàng
     */
    public function login(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Thử đăng nhập bằng mảng credentials
        if (Auth::attempt($credentials)) {

            // 3. Kiểm tra xem tài khoản có bị Admin khóa không (is_active = 0)
            if (Auth::user()->is_active == 0) {
                Auth::logout();
                return back()->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Hotline!');
            }

            return back()->with('success', 'Đăng nhập thành công! Chào mừng trở lại.');
        }

        // 4. Sai email hoặc pass
        return back()->with('error', 'Email hoặc mật khẩu không chính xác!');
    }

    /**
     * Xử lý Đăng ký tài khoản Khách hàng sỉ
     */
    public function register(Request $request)
    {
        // 1. Kiểm tra tính hợp lệ của dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // Yêu cầu có ô password_confirmation
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Email này đã được đăng ký trên hệ thống!',
            'password.min' => 'Mật khẩu bảo mật phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận mật khẩu nhập lại không trùng khớp!'
        ]);

        try {
            // 2. Tiến hành tạo tài khoản mới
            $user = new \App\Models\User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->is_active = true; // Khách tự đăng ký mặc định cho hoạt động luôn
            $user->save();

            // 3. Đăng nhập tự động cho khách ngay sau khi đăng ký xong
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Đăng ký tài khoản đại lý thành công! Chào mừng ông.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Đăng ký thất bại, có lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Xử lý Đăng xuất
     */
    public function logout()
    {
        Auth::logout();
        return back()->with('success', 'Đã đăng xuất tài khoản an toàn!');
    }
}
