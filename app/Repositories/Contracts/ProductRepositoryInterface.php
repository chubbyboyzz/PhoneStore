<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    /**
     * Lấy danh sách sản phẩm có phân trang (dùng cho Admin)
     */
    public function getPaginatedProducts(int $perPage = 10);

    /**
     * Lấy danh sách sản phẩm hiển thị trên Dashboard
     */
    public function getProductsForDashboard(int $limit = 10);

    /**
     * Lấy danh sách tất cả sản phẩm
     */
    public function getAll();

    /**
     * Lấy chi tiết một sản phẩm theo ID
     */
    public function findById(int $id);

    /**
     * Thêm mới một sản phẩm
     */
    public function create(array $data);

    /**
     * Cập nhật thông tin sản phẩm
     */
    public function update(int $id, array $data);

    /**
     * Xóa sản phẩm
     */
    public function delete(int $id);

    public function countAll(): int;
}
