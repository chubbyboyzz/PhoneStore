<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Dùng Model User để quản lý tài khoản khách

class CustomerController extends Controller
{
    // 1. Giao diện Danh sách & Tìm kiếm
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    // 2. Thuật toán Đảo trạng thái (Khóa / Mở khóa)
    public function toggle($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->is_active = !$user->is_active; // Đảo ngược trạng thái
            $user->save();

            $message = $user->is_active ? 'Đã MỞ KHÓA tài khoản thành công!' : 'Đã KHÓA tài khoản thành công!';
            return back()->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

   public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.unique' => 'Email này đã tồn tại trên hệ thống!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ]);

        // Tạo tài khoản
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->is_active = $request->is_active;
        $user->save();

        return redirect()->route('admin.customers.index')->with('success', 'Đã thêm khách hàng mới thành công!');
    }

    // KHỐI CHỈNH SỬA (EDIT & UPDATE)
    public function edit($id)
    {
        // ĐỔI TÊN BIẾN THÀNH $customer ĐỂ KHỚP VỚI VIEW CỦA ÔNG
        $customer = User::findOrFail($id);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        // Kiểm tra dữ liệu (bỏ qua check unique email của chính user này)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$customer->id,
        ]);

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->is_active = $request->is_active;

        // Nếu admin có nhập pass mới thì mới cập nhật pass
        if ($request->filled('password')) {
            $customer->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $customer->save();

        return redirect()->route('admin.customers.index')->with('success', 'Đã cập nhật thông tin khách hàng thành công!');
    }

    // KHỐI XÓA (DESTROY)
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return back()->with('success', 'Đã xóa khách hàng thành công!');
    }
}
