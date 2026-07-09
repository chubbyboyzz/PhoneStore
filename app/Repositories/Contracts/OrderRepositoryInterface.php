<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    /**
     * Truy xuất danh sách đơn hàng có phân trang
     * @param int $perPage Số lượng bản ghi trên mỗi trang
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Tìm kiếm đơn hàng theo ID (kèm theo Eager Loading để tối ưu truy vấn)
     * @param int $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id): Order;

    /**
     * Khởi tạo một đơn hàng mới vào cơ sở dữ liệu
     * @param array $data Mảng dữ liệu đã qua kiểm duyệt (Validated Data)
     */
    public function create(array $data): Order;

    /**
     * Cập nhật trạng thái đơn hàng dựa trên thuật toán State Machine
     * @param int $id ID đơn hàng
     * @param int $newStatus Trạng thái mới cần chuyển đổi
     * @throws \Exception
     */
    public function updateStatus(int $id, string $newStatus): bool;
}
