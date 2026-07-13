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
     * Luồng khởi chạy trang chủ + Xử lý Tìm kiếm/Sắp xếp/Lọc
     */
    public function index(Request $request): View
    {



        try {
            $query = Product::query();

            // Lọc theo Category
            if ($request->filled('category')) {
                $categorySlug = $request->category;

                // 1. Tìm ID của danh mục dựa trên slug
                $category = \App\Models\Category::where('slug', $categorySlug)->first();

                // 2. Ép truy vấn
                if ($category) {
                    $query->where('category_id', $category->id);
                } else {
                    // Phòng thủ (Defensive Programming):
                    // Nếu user tự gõ bừa 1 slug không tồn tại trên URL, ép truy vấn trả về mảng rỗng
                    $query->where('id', '<', 0);
                }
            }

            // Lọc theo Brand
            if ($request->filled('brand')) {
                $query->where('brand_id', $request->brand);
            }

            // Tìm kiếm
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            }

            // Sắp xếp
            if ($request->filled('sort')) {
                switch ($request->sort) {
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }




            $products = $query->paginate(12)->withQueryString();




            return view('frontend.home', compact('products'));

        } catch (Exception $e) {
            dd([
                'STATUS' => 'LỖI TRUY VẤN TRANG CHỦ',
                'MESSAGE' => $e->getMessage(),
                'LINE' => $e->getLine()
            ]);
        }
    }

    /**
     * Xử lý hiển thị Chi tiết Sản phẩm
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        try {
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
