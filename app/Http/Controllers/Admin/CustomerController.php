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

    // (Tạm giữ các hàm rỗng để không bị lỗi khi bấm nút Thêm/Sửa)
    public function create() {
        return view('admin.customers.create');
    }
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.customers.edit', compact('user'));
    }
    public function destroy($id) {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa khách hàng thành công!');
    }
}
