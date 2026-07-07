<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected ProductRepositoryInterface $productRepo;

    /**
     * Khởi tạo và tiêm bộ quản lý Sản phẩm vào bộ não Dashboard
     */
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Hàm xử lý chính trang Tổng quan
     */
    public function index()
    {
        // Thu thập tổng số lượng (cho thẻ Card)
        $totalProducts = $this->productRepo->countAll();

        // Thu thập danh sách tồn kho chi tiết (cho Bảng)
        $inventoryProducts = $this->productRepo->getProductsForDashboard(10);

        // Đẩy 2 biến này ra Presentation Layer
        return view('admin.dashboard', compact('totalProducts', 'inventoryProducts'));
    }

}
