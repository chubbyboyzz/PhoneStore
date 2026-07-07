<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Gọi Model Order

class AccountController extends Controller
{
    /**
     * Hiển thị danh sách lịch sử đơn hàng của khách sỉ
     */
    public function myOrders()
    {
        // Lấy các đơn hàng thuộc về user đang đăng nhập (Sắp xếp mới nhất lên đầu)
        // LƯU Ý: Nếu bảng orders của ông dùng cột 'customer_id' thì sửa lại chữ 'user_id' cho khớp nhé.
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('id', 'desc')
                       ->paginate(10);

        return view('frontend.account.orders', compact('orders'));
    }

    /**
     * Hiển thị trang Thông tin cá nhân
     */
    public function profile()
    {
        $user = Auth::user();
        return view('frontend.account.profile', compact('user'));
    }

    /**
     * Cập nhật Thông tin cá nhân & Đổi mật khẩu
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // Lấy user đang đăng nhập

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed', // Mật khẩu mới (nếu có nhập)
        ], [
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp!',
            'password.min' => 'Mật khẩu phải từ 6 ký tự.'
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Nếu khách có gõ mật khẩu mới thì mới cập nhật
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Đã cập nhật thông tin cá nhân thành công!');
    }
}
