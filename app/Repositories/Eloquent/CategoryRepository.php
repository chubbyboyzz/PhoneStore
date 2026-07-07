<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAllActive()
    {
        // Thuật toán lấy danh mục đang hoạt động, ưu tiên sort_order nhỏ hiện trước
        return $this->model->where('is_active', true)
                           ->orderBy('sort_order', 'asc')
                           ->get();
    }

    public function getPaginatedCategories(int $perPage = 10)
    {
        return $this->model->withCount('products') // Đếm sẵn số lượng sản phẩm thuộc danh mục này
                           ->orderBy('sort_order', 'asc')
                           ->paginate($perPage);
    }

    // Các hàm CRUD tiêu chuẩn
    public function findById(int $id) { return $this->model->findOrFail($id); }
    public function create(array $data) { return $this->model->create($data); }
    public function update(int $id, array $data)
    {
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }
    public function delete(int $id) { return $this->findById($id)->delete(); }
}
