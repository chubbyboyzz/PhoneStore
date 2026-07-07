<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Khai báo rõ kiểu dữ liệu cho IDE hiểu (Type Hinting)
     * @var Product
     */
    protected Product $model;

    // Tiêm (Inject) Model Product vào Constructor
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getPaginatedProducts(int $perPage = 10)
    {
        return $this->model->with(['category', 'brand'])
                           ->orderBy('created_at', 'desc')
                           ->paginate($perPage);
    }

    // --- BỔ SUNG CÁC HÀM CÒN THIẾU ĐỂ KHỚP VỚI INTERFACE ---

    public function getActiveProductsWithPagination(int $perPage = 10)
    {
        // Giả định bạn có scopeActive() trong Model Product
        return $this->model->where('is_active', true)
                           ->with(['category', 'brand'])
                           ->paginate($perPage);
    }

    public function searchProducts(string $keyword)
    {
        return $this->model->where('name', 'LIKE', "%{$keyword}%")->get();
    }

    // --- CÁC HÀM CRUD CƠ BẢN ---

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->findById($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->findById($id);
        return $product->delete();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function countAll(): int
    {
        return $this->model->count();
    }

    /**
     * Thực thi lấy danh sách thống kê tồn kho
     */
    public function getProductsForDashboard(int $limit = 10)
    {
        return $this->model->orderBy('stock_quantity', 'desc')
                           ->limit($limit)
                           ->get(['id', 'name', 'stock_quantity']); // Lấy ID để có thể click xem chi tiết
    }
}
