<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreProductRequest;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\UpdateProductRequest;


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
        // Truy xuất dữ liệu cho Dropdown List (chỉ lấy các trường cần thiết để tối ưu RAM)
        $categories = Category::orderBy('sort_order', 'asc')->get(['id', 'name']);
        $brands = Brand::orderBy('name', 'asc')->get(['id', 'name']);

        // Trả về View kèm theo DTO (Data Transfer Object)
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function destroy(int $id)
    {
        // 1. Dùng Repository để lấy thực thể Product (tự động văng 404 nếu không tồn tại)
        $product = $this->productRepo->findById($id);

        // 2. Thuật toán dọn dẹp bộ nhớ (Xóa ảnh vật lý trên đĩa)
        // Kiểm tra xem ảnh có tồn tại và không phải là link HTTP/URL ngoài
        if ($product->thumbnail && !str_contains($product->thumbnail, 'http')) {

            // Loại bỏ prefix '/storage/' để lấy đường dẫn thực tế tương đối trong disk 'public'
            // Ví dụ từ: /storage/products/abc.png -> products/abc.png
            $imagePath = str_replace('/storage/', '', $product->thumbnail);

            // Kiểm tra an toàn: Nếu file vật lý thực sự tồn tại trên ổ cứng thì mới ra lệnh xóa
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // 3. Ra lệnh cho Repository xóa bản ghi trong CSDL
        $this->productRepo->delete($id);

        // 4. Trả về giao diện kèm tín hiệu Flash Session
        return redirect()->route('admin.products.index')
                         ->with('success', 'Hệ thống đã xóa sản phẩm và giải phóng ổ cứng thành công!');
    }


    /**
     * Giai đoạn 1: Ánh xạ dữ liệu lên Form (Data Binding)
     */
    public function edit(int $id)
    {
        // Sử dụng Repository để nạp thực thể
        $product = $this->productRepo->findById($id);

        // Truy xuất danh mục và thương hiệu (DTO cho Dropdown)
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

        // Xử lý luồng I/O Tệp tin
        if ($request->hasFile('thumbnail')) {
            // 1. Dọn dẹp tệp tin cũ khỏi ổ đĩa vật lý
            if ($product->thumbnail && !str_contains($product->thumbnail, 'http')) {
                $oldImagePath = str_replace('/storage/', '', $product->thumbnail);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            // 2. Nạp tệp tin mới và lấy định tuyến tĩnh
            $path = $request->file('thumbnail')->store('products', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        }

        // Bàn giao cho tầng Data Access (Repository) thực thi cập nhật
        $this->productRepo->update($id, $data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Bản ghi đã được cập nhật đồng bộ!');
    }

    /**
     * Hiển thị danh sách sản phẩm có phân trang
     */
    public function index()
    {
        // Gọi hàm từ Repository, mỗi trang 10 sản phẩm
        $products = $this->productRepo->getPaginatedProducts(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * 2. HÀM STORE ĐÓN REQUEST ĐÃ QUA KIỂM DUYỆT
     */

    public function store(StoreProductRequest $request)
    {
       // Lấy toàn bộ dữ liệu đã pass qua mảng rules()
        $data = $request->validated();

        // Thuật toán sinh tự động các trường không có trong Form
        $data['slug'] = Str::slug($data['name']); // Tạo URL thân thiện (vd: iphone-15-pro)
        $data['sku'] = 'SP' . strtoupper(Str::random(6)); // Mã SKU ngẫu nhiên (vd: SP8F2A1)

        // Xử lý Checkbox (Nếu không tích thì form sẽ không gửi lên, mặc định là null)
        $data['is_active'] = $request->has('is_active') ? 1 : 0;


       if ($request->hasFile('thumbnail')) {
            // Lưu file vào thư mục storage/app/public/products
            $path = $request->file('thumbnail')->store('products', 'public');

            // Format lại đường dẫn để View có thể đọc được qua thẻ <img>
            $data['thumbnail'] = '/storage/' . $path;
        } else {
            // Nếu không up ảnh, giữ nguyên ảnh mặc định
            $data['thumbnail'] = 'https://via.placeholder.com/150';
        }

        // Gọi Repository để ghi vào CSDL
        $this->productRepo->create($data);

        // Chuyển hướng về trang danh sách kèm thông báo Flash Session
        return redirect()->route('admin.products.index')
                         ->with('success', 'Đã thêm sản phẩm mới thành công!');
    }
}
