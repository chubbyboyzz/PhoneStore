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
        // 1. RÀO CHẮN KIỂM DUYỆT (Validation Layer)
        // Hệ thống sẽ tự động quét CSDL và chặn đứng Request nếu phát hiện trùng lặp
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',

            // THUẬT TOÁN MỚI: Ràng buộc tính duy nhất của Số điện thoại
            // Chuyển từ 'nullable' sang 'required' vì đây là kênh liên hệ chốt sale
            'phone' => 'required|string|max:20|unique:users,phone',

            'address' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Email này đã được đăng ký trên hệ thống!',
            'password.min' => 'Mật khẩu bảo mật phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận mật khẩu nhập lại không trùng khớp!',

            // THÔNG BÁO LỖI UI/UX: Hiển thị cảnh báo trực quan khi nhập trùng SĐT
            'phone.required' => 'Vui lòng cung cấp số điện thoại Zalo để đối soát.',
            'phone.unique' => 'Số điện thoại này đã được kết nối với một đại lý khác!'
        ]);

        try {
            // 2. TẦNG THỰC THỂ (Entity Model)
            // Áp dụng Mass Assignment (OOP) thay vì gán tay từng thuộc tính
            // Lưu ý: Đảm bảo Model User đã khai báo $fillable cho các trường này
            \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => 0 // Đóng băng tài khoản, chờ Admin phê duyệt
            ]);

            return back()->with('success', 'Đã gửi yêu cầu đăng ký tài khoản thành công! Vui lòng chờ Admin duyệt và kích hoạt.');

        } catch (\Exception $e) {
            // 3. TẦNG XỬ LÝ NGOẠI LỆ (Exception Handling)
            return back()->withInput()->with('error', 'Đăng ký thất bại, sự cố hệ thống: ' . $e->getMessage());
        }
    }

    /**
     * Xử lý Đăng xuất
     */
    public function logout(Request $request)
    {
       Auth::logout();

        // Hủy session cũ và tạo token mới để chống hack CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ÉP ĐÁ VỀ TRANG CHỦ thay vì quay lại trang cũ
        return redirect()->route('home')->with('success', 'Đã đăng xuất tài khoản an toàn!');
    }
}
