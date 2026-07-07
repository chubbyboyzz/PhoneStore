<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 15): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Ưu tiên hiển thị khách hàng mới đăng ký lên đầu
        return $this->model->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function toggleStatus(int $id): bool
    {
        $customer = $this->model->findOrFail($id);
        // Thuật toán Đảo bit thông minh: Đang 1 thành 0, đang 0 thành 1
        $customer->is_active = !$customer->is_active;
        return $customer->save();
    }
}
