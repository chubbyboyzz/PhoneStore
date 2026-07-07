<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    /**
     * Lấy danh sách khách hàng có phân trang
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator;

    /**
     * Thuật toán đảo ngược trạng thái hoạt động (Khóa/Mở khóa)
     */
    public function toggleStatus(int $id): bool;
}
