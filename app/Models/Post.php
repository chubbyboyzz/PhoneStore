<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'images',
        'status',
        'published_at'
    ];

    /**
     * Tự động cast cột images từ JSON thành mảng PHP.
     * Khi gọi $post->images, ông nhận được array ngay lập tức.
     */
    protected $casts = [
        'images' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * Scope để lấy bài viết đã xuất bản (thực tế và dễ bảo trì).
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }
}
