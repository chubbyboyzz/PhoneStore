<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    // Khai báo các nghiệp vụ đặc thù ngoài CRUD cơ bản
    public function getActiveProductsWithPagination(int $perPage);
    public function searchProducts(string $keyword);
}
