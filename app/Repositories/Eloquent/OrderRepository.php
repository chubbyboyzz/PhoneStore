<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Enums\OrderStatus;
use Exception;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Khai báo kiểu dữ liệu nghiêm ngặt cho Model (Strong Typing)
     */
    protected Order $model;

    /**
     * Tiêm phụ thuộc (Dependency Injection) Model vào Repository
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Tối ưu thuật toán: Sử dụng with('user') để gom các truy vấn Khách hàng thành 1 câu SQL duy nhất
        return $this->model->with('user')
                           ->orderBy('created_at', 'desc')
                           ->paginate($perPage);
    }

    public function findById(int $id): Order
    {
        // Tối ưu hóa kiến trúc dữ liệu: Kéo sẵn thông tin User và mảng Chi tiết đơn hàng (Order Items)
        return $this->model->with(['user', 'orderItems.product'])->findOrFail($id);
    }

    public function create(array $data): Order
    {
        // Giao tiếp với Database để tạo bản ghi
        return $this->model->create($data);
    }

    public function updateStatus(int $id, int $newStatus): bool
    {
        // 1. Kéo dữ liệu thực tế từ DB lên
        $order = $this->findById($id);

        // 2. Thuật toán kiểm chứng trạng thái (Fail-Fast Method)
        // Gọi thẳng vào logic tĩnh của Enum để đảm bảo tính đóng gói (Encapsulation)
        if (!OrderStatus::canTransition($order->status, $newStatus)) {
            throw new Exception("Lỗi nghiệp vụ: Luồng chuyển đổi trạng thái từ [{$order->status}] sang [{$newStatus}] vi phạm quy tắc hệ thống.");
        }

        // 3. Thực thi lưu trữ nếu hợp lệ
        $order->status = $newStatus;
        return $order->save();
    }
}
