<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 'price',
        'wholesale_price', 'stock_quantity', 'description', 'thumbnail',
        'is_featured', 'views', 'is_active', 'gallery'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'gallery' => 'array', // Lưu trữ dưới dạng mảng JSON
    ];

    // Quan hệ N-1: Nhiều Sản phẩm thuộc 1 Danh mục/Thương hiệu
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    // Logic tìm kiếm đa trường được đóng gói thông minh
    public function scopeSearch(Builder $query, string $keyword)
    {
        if (!empty($keyword)) {
            return $query->where('name', 'LIKE', "%{$keyword}%")
                         ->orWhere('sku', 'LIKE', "%{$keyword}%");
        }
        return $query;
    }

    public function getApplicablePriceAttribute()
    {
        return \Illuminate\Support\Facades\Auth::check() ? $this->wholesale_price : $this->price;
    }
}
