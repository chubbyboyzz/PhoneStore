<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminUserController extends Controller
{
    protected AdminRepositoryInterface $adminRepo;

    public function __construct(AdminRepositoryInterface $adminRepo)
    {
        $this->adminRepo = $adminRepo;
    }

    public function index()
    {
        $admins = $this->adminRepo->getPaginated(10);
        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $this->adminRepo->create($data);
        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản quản trị thành công!');
    }

    public function edit(int $id)
    {
        // 1. Log cắm mốc thời điểm Request đi vào Controller
        Log::info("--- BẮT ĐẦU VÀO HÀM EDIT ---");
        Log::info("Nhận được ID truyền vào: " . $id);

        try {
            // Bước 1: Chọc xuống Database
            $adminUser = $this->adminRepo->findById($id);
            Log::info("Truy vấn DB thành công. Dữ liệu: ", $adminUser->toArray());

            $currentUser = Auth::guard('admin')->user();
            Log::info("Người đang thao tác: " . $currentUser->email);

            // Bước 2: Xử lý logic phân quyền
            if ($currentUser->role !== 'superadmin' && $adminUser->role === 'superadmin') {
                Log::warning("CẢNH BÁO: Bị chặn do vi phạm luồng phân quyền!");
                abort(403, 'Lỗi Bảo Mật: Bạn không có quyền truy cập vào tài khoản Super Admin.');
            }

            Log::info("Vượt qua check bảo mật, chuẩn bị render View.");

            // 2. KỸ THUẬT FAIL-FAST (Tương đương Breakpoint trong C#)
            // Ông hãy gỡ comment dòng dd() bên dưới ra để xem hệ thống có in ra dữ liệu rồi dừng lại không.
            // Nếu nó in ra được tức là Controller không lỗi, lỗi nằm 100% ở file View.

            // dd($adminUser);

            return view('admin.users.edit', compact('adminUser'));

        } catch (\Exception $e) {
            // 3. Bắt trọn toàn bộ lỗi (Database, Null Pointer, Syntax...)
            Log::error("🔥 LỖI TẠI HÀM EDIT: " . $e->getMessage());
            Log::error("Tại dòng: " . $e->getLine() . " - File: " . $e->getFile());

            // In thẳng lỗi ra màn hình thay vì trang trắng
            dd("Hệ thống phát hiện lỗi: " . $e->getMessage() . " (Xem chi tiết trong laravel.log)");
        }
    }

    public function update(UpdateAdminRequest $request, int $id)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $this->adminRepo->update($id, $data);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Thuật toán bảo vệ toàn vẹn hệ thống
     */
    public function destroy(int $id)
    {
        $targetUser = $this->adminRepo->findById($id);
        $currentUser = Auth::guard('admin')->user();

        if ($currentUser->id == $id) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể tự xóa chính mình!');
        }

        // Chặn Manager xóa Superadmin
        if ($currentUser->role !== 'superadmin' && $targetUser->role === 'superadmin') {
            return redirect()->route('admin.users.index')->with('error', 'Giới hạn phân quyền: Không thể xóa Super Admin.');
        }

        $this->adminRepo->delete($id);
        return redirect()->route('admin.users.index')->with('success', 'Đã thu hồi tài khoản!');
    }
}
