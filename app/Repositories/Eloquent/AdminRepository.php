<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin; // Giả định ông đã có Model Admin từ lúc làm Multi-Auth
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    protected Admin $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->model->orderBy('id', 'desc')->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        // Mã hóa mật khẩu trước khi lưu
        $data['password'] = Hash::make($data['password']);
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $admin = $this->findById($id);

        // Thuật toán: Chỉ mã hóa và cập nhật mật khẩu nếu người dùng có nhập mới
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Nếu bỏ trống thì giữ nguyên mật khẩu cũ
            unset($data['password']);
        }

        $admin->update($data);
        return $admin;
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
