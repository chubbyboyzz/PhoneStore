<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Tài khoản Admin cốt lõi (Để test chức năng Đăng nhập)
        Admin::create([
            'name' => 'Quản trị viên',
            'email' => 'admin@phonestore.com',
            'password' => Hash::make('123456'), // Mã hóa MD5/Bcrypt
            'phone' => '0987654321',
            'role' => 'superadmin',
            'is_active' => true,
        ]);

        // 2. Tạo Danh sách Thương hiệu thực tế
        $brands = ['Apple', 'Samsung', 'Xiaomi', 'Oppo'];
        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
                'slug' => Str::slug($brand),
            ]);
        }

        // 3. Tạo Danh sách Danh mục thực tế
        $categories = ['Điện thoại thông minh', 'Máy tính bảng', 'Phụ kiện', 'Đồng hồ thông minh'];
        foreach ($categories as $index => $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
                'sort_order' => $index,
            ]);
        }

        // 4.Gọi Factory đúc ra 50 sản phẩm mẫu nhét vào CSDL
        Product::factory(50)->create();
    }
}
