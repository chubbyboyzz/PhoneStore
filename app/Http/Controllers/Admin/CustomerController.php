<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected CustomerRepositoryInterface $customerRepo;

    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function index()
    {
        $customers = $this->customerRepo->getPaginated(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function toggleStatus(int $id)
    {
        try {
            $this->customerRepo->toggleStatus($id);
            return redirect()->back()->with('success', 'Đã cập nhật trạng thái tài khoản khách hàng!');
        } catch (\Exception $e) {
            Log::error("Lỗi cập nhật trạng thái KH #$id: " . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xử lý yêu cầu lúc này.');
        }
    }
}
