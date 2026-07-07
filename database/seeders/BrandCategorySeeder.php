<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;

class BrandCategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kéo toàn bộ danh mục và thương hiệu đang có trong DB lên
        $categories = Category::all();
        $brands = Brand::all();

        // Lập trình phòng thủ: Đảm bảo DB có dữ liệu thì mới chạy tiếp
        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->warn('Chưa có dữ liệu Category hoặc Brand. Bỏ qua việc nối bảng.');
            return;
        }

        // 2. Thuật toán phân bổ tự động: Gán ngẫu nhiên 2-4 Brand cho mỗi Category
        foreach ($categories as $category) {
            // Lấy ngẫu nhiên vài ID của Brand
            $randomBrandIds = $brands->random(rand(2, 4))->pluck('id')->toArray();

            // Dùng hàm attach() để tự động insert dữ liệu vào bảng brand_category
            // syncWithoutDetaching giúp tránh việc bị insert trùng lặp (Duplicate Key)
            $category->brands()->syncWithoutDetaching($randomBrandIds);
        }

        $this->command->info('🔥 Đã nối dữ liệu thành công! Menu đa cấp đã sẵn sàng hoạt động.');
    }
}
