<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreCategoryRequest;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepo;


    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }


    public function index()
    {
        // Gọi hàm phân trang đã tối ưu thuật toán đếm (withCount)
        $categories = $this->categoryRepo->getPaginatedCategories(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị Form nhập liệu
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Tiếp nhận dữ liệu sạch, xử lý thuật toán và ghi vào CSDL
     */
    public function store(StoreCategoryRequest $request)
    {
        // Lấy mảng dữ liệu đã vượt qua vòng kiểm duyệt rules()
        $data = $request->validated();

        // Thuật toán sinh Slug tự động chuẩn SEO từ Tên danh mục
        $data['slug'] = Str::slug($data['name']);

        // Xử lý giá trị mặc định cho trường sort_order nếu người dùng bỏ trống
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Xử lý Checkbox trạng thái hiển thị
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Gọi tầng Data Access (Repository) ghi dữ liệu vào DB
        $this->categoryRepo->create($data);

        // Điều hướng kèm thông báo Flash Session thành công
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Đã thêm danh mục mới thành công!');
    }


    // Hàm hiển thị Form chỉnh sửa danh mục
    public function edit(int $id)
    {
        $category = $this->categoryRepo->findById($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Hàm tiếp nhận dữ liệu chỉnh sửa và ghi đè vào DB
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $data = $request->validated();
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Bàn giao cho Repository thực thi update
        $this->categoryRepo->update($id, $data);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Đã cập nhật danh mục thành công!');
    }


    // Hàm xóa danh mục
    public function destroy(int $id)
    {
        $category = $this->categoryRepo->findById($id);

        // Kỹ thuật bảo vệ Toàn vẹn dữ liệu: Kiểm tra xem danh mục có đang chứa sản phẩm không?
        if ($category->products()->count() > 0) {
            // Từ chối xóa và ném lỗi ngược lại View
            return redirect()->route('admin.categories.index')
                             ->with('error', 'Không thể xóa! Danh mục này đang chứa sản phẩm. Hãy chuyển sản phẩm sang danh mục khác trước.');
        }

        // Nếu an toàn, tiến hành xóa
        $this->categoryRepo->delete($id);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Đã xóa danh mục thành công!');
    }
}
