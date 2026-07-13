<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Http\Requests\Admin\PostRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected PostRepositoryInterface $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    // 1. Render danh sách
    public function index()
    {
        $posts = $this->postRepo->getAll(15);
        return view('admin.posts.index', compact('posts'));
    }

    // 2. Render Form thêm mới (Hàm vừa bổ sung)
    public function create()
    {
        return view('admin.posts.create');
    }

    // 3. Xử lý lưu dữ liệu thêm mới
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('images')) {
            $data['images'] = $this->handleImageUpload($request->file('images'));
        }
        $data['slug'] = Str::slug($data['title']);

        $this->postRepo->create($data);
        return redirect()->route('admin.posts.index')->with('success', 'Đã thêm bài viết!');
    }

    // 4. Render Form chỉnh sửa
    public function edit(int $id)
    {
        $post = $this->postRepo->findById($id);
        return view('admin.posts.edit', compact('post'));
    }

    // 5. Xử lý lưu dữ liệu cập nhật
    public function update(PostRequest $request, int $id)
    {
        $data = $request->validated();
        $this->postRepo->update($id, $data);
        return redirect()->route('admin.posts.index')->with('success', 'Đã cập nhật!');
    }

    // 6. Xử lý xóa
    public function destroy(int $id)
    {
        $this->postRepo->delete($id);
        return redirect()->back()->with('success', 'Đã xóa bài viết!');
    }

    // 7. Hàm helper xử lý file (Private)
    private function handleImageUpload(array $files): array
    {
        return array_map(fn($f) => $f->store('posts', 'public'), $files);
    }
}
