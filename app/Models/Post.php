<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Builder;

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

   protected static function booted()
    {
        static::saving(function ($post) {
            // Nếu chuyển trạng thái sang Published và chưa có ngày đăng -> Gán thời gian hiện tại
            if ($post->status === 'published' && is_null($post->published_at)) {
                $post->published_at = now();
            }
            // Nếu Admin quay xe đổi lại thành Draft -> Reset ngày đăng về NULL
            elseif ($post->status === 'draft') {
                $post->published_at = null;
            }
        });
    }
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
