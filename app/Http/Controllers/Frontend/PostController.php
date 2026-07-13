<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostRepositoryInterface $postRepo;

    // Sử dụng Dependency Injection để tiêm Interface vào Controller
    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    /**
     * Danh sách bài viết (Hiển thị cho khách hàng)
     */
    public function index()
    {
        // Phân trang 10 bài/trang để tối ưu bộ nhớ
        $posts = $this->postRepo->getAll(10);
        return view('frontend.posts.index', compact('posts'));
    }

    /**
     * Chi tiết bài viết
     */
    public function show(string $slug)
    {
        // Repository trả về Model, Controller chỉ cần đổ vào view
        $post = $this->postRepo->findById($slug);
        return view('frontend.posts.show', compact('post'));
    }
}
