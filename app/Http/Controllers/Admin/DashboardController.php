<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    protected ProductRepositoryInterface $productRepo;
    protected OrderRepositoryInterface $orderRepo;
    protected CustomerRepositoryInterface $customerRepo;

    /**
     * Khởi tạo và tiêm bộ quản lý Sản phẩm vào bộ não Dashboard
     */
    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo,
        CustomerRepositoryInterface $customerRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->customerRepo = $customerRepo;
    }

    /**
     * Hàm xử lý chính trang Tổng quan
     */
    public function index()
    {
        // 1. Thu thập các chỉ số tổng quan (Metrics)
        $totalProducts = $this->productRepo->countAll();
        $newOrdersCount = $this->orderRepo->countPending();
        $customersCount = $this->customerRepo->countAll();

        // 2. Thu thập dữ liệu phân tích sâu (Data Tables)
        $inventoryProducts = $this->productRepo->getProductsForDashboard(10);
        $lowStockProducts = $this->productRepo->getLowStockProducts(5); // Ngưỡng <= 5 cái

        // 3. Đẩy toàn bộ dữ liệu ra Presentation Layer
        return view('admin.dashboard', compact(
            'totalProducts',
            'inventoryProducts',
            'newOrdersCount',
            'customersCount',
            'lowStockProducts'
        ));
    }

}
