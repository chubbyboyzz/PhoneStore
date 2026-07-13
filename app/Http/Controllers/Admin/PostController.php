<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Http\Requests\Admin\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected PostRepositoryInterface $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        $posts = $this->postRepo->getAll(15);
        return view('admin.posts.index', compact('posts'));
    }

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

    public function edit(int $id)
    {
    $post = $this->postRepo->findById($id);
    return view('admin.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, int $id)
    {
        $data = $request->validated();
        // Cập nhật logic: Nếu upload ảnh mới, xóa ảnh cũ (nếu cần)
        $this->postRepo->update($id, $data);
        return redirect()->route('admin.posts.index')->with('success', 'Đã cập nhật!');
    }

    public function destroy( int $id)
    {
        $this->postRepo->delete($id);
        return redirect()->back()->with('success', 'Đã xóa bài viết!');
    }

    private function handleImageUpload( array $files): array {
        // Logic xử lý upload và resize tại đây
        return array_map(fn($f) => $f->store('posts', 'public'), $files);
    }
}
