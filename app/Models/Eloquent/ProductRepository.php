<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    // Thực thi các nghiệp vụ đặc thù
    public function getActiveProductsWithPagination(int $perPage = 10)
    {
        // Tận dụng Local Scope active() đã viết ở Model trước đó
        return $this->model->active()->with(['category', 'brand'])->paginate($perPage);
    }

    public function searchProducts(string $keyword)
    {
        return $this->model->active()->search($keyword)->get();
    }
}
