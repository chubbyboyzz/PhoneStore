<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreProductRequest;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\UpdateProductRequest;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepo;

    // Khởi tạo Dependency Injection: Trừu tượng hóa hoàn toàn tầng CSDL
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Hiển thị Form thêm mới Sản phẩm
     */
    public function create()
    {
        $categories = Category::orderBy('sort_order', 'asc')->get(['id', 'name']);
        $brands = Brand::orderBy('name', 'asc')->get(['id', 'name']);

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function destroy(int $id)
    {
        // 1. Dùng Repository để lấy thực thể Product
        $product = $this->productRepo->findById($id);

        // 2. Thuật toán dọn dẹp bộ nhớ (Xóa ảnh Thumbnail)
        if ($product->thumbnail && !str_contains($product->thumbnail, 'http')) {
            $imagePath = str_replace('/storage/', '', $product->thumbnail);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // THÊM MỚI: Thuật toán dọn dẹp bộ nhớ (Xóa ảnh trong Gallery)
        if (!empty($product->gallery) && is_array($product->gallery)) {
            foreach ($product->gallery as $img) {
                if ($img && !str_contains($img, 'http')) {
                    $imgPath = str_replace('/storage/', '', $img);
                    if (Storage::disk('public')->exists($imgPath)) {
                        Storage::disk('public')->delete($imgPath);
                    }
                }
            }
        }

        // 3. Ra lệnh cho Repository xóa bản ghi trong CSDL
        $this->productRepo->delete($id);

        // 4. Trả về giao diện
        return redirect()->route('admin.products.index')
                         ->with('success', 'Hệ thống đã xóa sản phẩm và giải phóng ổ cứng thành công!');
    }

    /**
     * Giai đoạn 1: Ánh xạ dữ liệu lên Form (Data Binding)
     */
    public function edit(int $id)
    {
        $product = $this->productRepo->findById($id);

        $categories = Category::orderBy('sort_order', 'asc')->get(['id', 'name']);
        $brands = Brand::orderBy('name', 'asc')->get(['id', 'name']);

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Giai đoạn 2: Tiếp nhận thay đổi và Ghi đè (Resource Modification)
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->validated();
        $product = $this->productRepo->findById($id);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Xử lý luồng I/O Tệp tin (Thumbnail)
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && !str_contains($product->thumbnail, 'http')) {
                $oldImagePath = str_replace('/storage/', '', $product->thumbnail);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            $path = $request->file('thumbnail')->store('products', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        }

        // THÊM MỚI: Xử lý I/O Tệp tin (Gallery)
        if ($request->hasFile('gallery')) {
            // Xóa file vật lý của gallery cũ
            if (!empty($product->gallery) && is_array($product->gallery)) {
                foreach ($product->gallery as $oldImage) {
                    if ($oldImage && !str_contains($oldImage, 'http')) {
                        $oldImagePath = str_replace('/storage/', '', $oldImage);
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                        }
                    }
                }
            }

            // Lưu mảng ảnh mới
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('products/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path; // Đồng bộ quy tắc thêm prefix /storage/ của ông
            }
            $data['gallery'] = $galleryPaths;
        }

        // Bàn giao cho tầng Data Access (Repository) thực thi cập nhật
        $this->productRepo->update($id, $data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Bản ghi đã được cập nhật đồng bộ!');
    }

    /**
     * Hiển thị danh sách sản phẩm có phân trang
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * 2. HÀM STORE ĐÓN REQUEST ĐÃ QUA KIỂM DUYỆT
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);
        $data['sku'] = 'SP' . strtoupper(Str::random(6));
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Ảnh chính
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        } else {
            $data['thumbnail'] = 'https://via.placeholder.com/150';
        }

        // THÊM MỚI: Ảnh bộ sưu tập
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('products/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $data['gallery'] = $galleryPaths;
        }

        // Gọi Repository để ghi vào CSDL
        $this->productRepo->create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Đã thêm sản phẩm mới thành công!');
    }
}
