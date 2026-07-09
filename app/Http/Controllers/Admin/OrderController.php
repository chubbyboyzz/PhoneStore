<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Exception;

class OrderController extends Controller
{
    protected OrderRepository $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    // Luồng Read: Xem danh sách
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    // Luồng Detail: Xem chi tiết 1 đơn
    public function show(int $id)
    {
        $order = $this->orderRepo->findById($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Luồng Update: Cập nhật trạng thái đơn hàng
     * @param Request $request
     * @param int $id (Đúng phải là id)
     */
    public function updateStatus(Request $request, int $id)
    {
        // 1. Validate: Status phải là 1 trong 3 giá trị ENUM
        $request->validate([
            'status' => 'required|in:pending,completed,canceled'
        ]);

        try {
            // 2. Gọi Repository cập nhật (truyền đúng $id và status string)
            $this->orderRepo->updateStatus($id, $request->status);

            return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');

        } catch (Exception $e) {
            Log::error("Lỗi cập nhật đơn hàng #$id: " . $e->getMessage());

            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái: ' . $e->getMessage());
        }
    }
}
