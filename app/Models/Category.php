<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function brands()
    {
       return $this->belongsToMany(Brand::class, 'brand_category', 'category_id', 'brand_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}
