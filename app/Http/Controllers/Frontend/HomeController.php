<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Exception;

class HomeController extends Controller
{
    /**
     * Luồng khởi chạy trang chủ + Xử lý bộ lọc Danh mục/Brand
     */
    public function index(Request $request): View
    {
        try {
            $query = Product::query();

            // Lọc theo Category
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            // Lọc theo Brand
            if ($request->filled('brand')) {
                $query->where('brand_id', $request->brand);
            }

            $products = $query->orderBy('created_at', 'desc')
                              ->paginate(12)
                              ->withQueryString();

            return view('frontend.home', compact('products'));

        } catch (Exception $e) {
            dd([
                'STATUS' => 'LỖI TRUY VẤN TRANG CHỦ',
                'MESSAGE' => $e->getMessage()
            ]);
        }
    }


    /**
     * Xử lý hiển thị Chi tiết Sản phẩm
     * * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        try {
            // Lấy đúng 1 sản phẩm theo ID
            $product = Product::findOrFail($id);

            return view('frontend.product-detail', compact('product'));

        } catch (Exception $e) {
            dd([
                'STATUS' => 'LỖI TRUY VẤN CHI TIẾT SẢN PHẨM',
                'MESSAGE' => $e->getMessage()
            ]);
        }
    }
}
