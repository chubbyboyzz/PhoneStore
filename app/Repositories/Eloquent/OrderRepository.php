<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Enums\OrderStatus;
use Exception;

class OrderRepository implements OrderRepositoryInterface
{
    protected Order $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model->with('user')
                           ->orderBy('created_at', 'desc')
                           ->paginate($perPage);
    }

    public function findById(int $id): Order
    {
        return $this->model->with(['user', 'details'])->findOrFail($id);
    }

    public function create(array $data): Order
    {
        return $this->model->create($data);
    }

    /**
     * SỬA LẠI: Thay int $newStatus bằng string $newStatus
     */
    public function updateStatus(int $id, string $newStatus): bool
    {
        // 1. Kéo dữ liệu thực tế từ DB lên
        $order = $this->findById($id);

        // 2. Kiểm tra logic chuyển đổi trạng thái
        // Lưu ý: Đảm bảo hàm OrderStatus::canTransition của ông
        // cũng nhận vào tham số là string thay vì int
        if (!OrderStatus::canTransition($order->status, $newStatus)) {
            throw new Exception("Lỗi nghiệp vụ: Luồng chuyển đổi trạng thái từ [{$order->status}] sang [{$newStatus}] vi phạm quy tắc hệ thống.");
        }

        // 3. Thực thi lưu trữ
        $order->status = $newStatus;
        return $order->save();
    }
}
