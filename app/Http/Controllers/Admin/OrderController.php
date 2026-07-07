<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Requests\Admin\StoreOrderRequest;

class OrderController extends Controller
{
    protected OrderRepository $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    // Luồng Read: Xem danh sách
    public function index()
    {
        $orders = $this->orderRepo->getPaginated(15);
        return view('admin.orders.index', compact('orders'));
    }

    // Luồng Detail: Xem chi tiết 1 đơn
    public function show(int $id)
    {
        $order = $this->orderRepo->findById($id);
        return view('admin.orders.show', compact('order'));
    }

    // Luồng Update: Cập nhật trạng thái
    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|integer']);

        try {
            $this->orderRepo->updateStatus($id, $request->status);
            return redirect()->back()->with('success', 'Đã cập nhật tiến độ đơn hàng!');
        } catch (\Exception $e) {
            Log::warning("Xung đột State Machine Đơn hàng #$id: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    //Luồng hiển thị Form tạo mới Đơn hàng
    public function create()
    {
        // Tối ưu hóa truy vấn: Chỉ lấy các trường cần thiết phục vụ cho thẻ <select>
        $customers = User::select('id', 'name', 'phone')->orderBy('name', 'asc')->get();
        return view('admin.orders.create', compact('customers'));
    }

    // Luồng Store: Xử lý lưu mới Đơn hàng
    public function store(StoreOrderRequest $request)
    {
        try {
            // Nhờ Form Request, dữ liệu đến đây 100% đã sạch và hợp lệ
            $validatedData = $request->validated();

            // Lưu xuống DB thông qua Repository
            $this->orderRepo->create($validatedData);

            return redirect()->route('admin.orders.index')
                             ->with('success', 'Đã khởi tạo đơn hàng mới thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi tạo đơn hàng: " . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Hệ thống gián đoạn, không thể tạo đơn hàng.')
                             ->withInput();
        }
    }
}
