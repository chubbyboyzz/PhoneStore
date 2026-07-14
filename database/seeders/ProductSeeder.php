<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Thực thi tiến trình sinh dữ liệu giả lập (Mocking)
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // 1. Dọn dẹp dữ liệu cũ (Truncate)
        // Tắt kiểm tra khóa ngoại (Foreign Key) tạm thời để tránh lỗi Constraint Fails khi xóa
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Trích xuất ID ngẫu nhiên từ các bảng liên kết (Phòng ngừa lỗi thiếu dữ liệu nòng cốt)
        $categoryIds = Category::pluck('id')->toArray() ?: [1, 2, 3];
        $brandIds = Brand::pluck('id')->toArray() ?: [1, 2, 3];

        $products = [];

        // 3. Vòng lặp sinh dữ liệu độc lập
        for ($i = 1; $i <= 50; $i++) {
            $name = $faker->unique()->sentence(4);

            // Khởi tạo giá trị ngẫu nhiên hoàn toàn độc lập (Không dùng công thức tỷ lệ)
            // Làm tròn đến hàng chục nghìn để số liệu hiển thị thực tế hơn
            $retailPrice = round($faker->numberBetween(3000000, 25000000) / 10000) * 10000;
            $wholesalePrice = round($faker->numberBetween(1000000, $retailPrice - 500000) / 10000) * 10000;

            $products[] = [
                'category_id' => $faker->randomElement($categoryIds),
                'brand_id' => $faker->randomElement($brandIds),
                'name' => $name,
                'slug' => Str::slug($name),
                'sku' => 'SP-' . strtoupper(Str::random(6)),
                'price' => $retailPrice,             // Giá bán lẻ
                'wholesale_price' => $wholesalePrice, // Giá bán sỉ
                'stock_quantity' => $faker->numberBetween(0, 500),
                'description' => '<p>' . $faker->paragraphs(3, true) . '</p>',
                'thumbnail' => 'https://via.placeholder.com/400x400?text=Product+' . $i,
                'gallery' => json_encode([
                    'https://via.placeholder.com/400x400?text=Gallery+A',
                    'https://via.placeholder.com/400x400?text=Gallery+B'
                ]),
                'is_featured' => $faker->boolean(15),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 4. Ghi dữ liệu theo lô (Batch Insert) - Kỹ thuật tối ưu I/O thay vì insert từng dòng
        DB::table('products')->insert($products);

        $this->command->info('Tiến trình hoàn tất: Đã xóa toàn bộ dữ liệu cũ và sinh thành công 50 bản ghi giả lập.');
    }
}
