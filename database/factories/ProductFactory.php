<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Tạo tên sản phẩm ngẫu nhiên từ một danh sách các mẫu điện thoại phổ biến
        $name = $this->faker->randomElement(['iPhone 15', 'Samsung Galaxy S24', 'Xiaomi 14', 'Oppo Find X7']) . ' ' . $this->faker->words(2, true);
        $price = $this->faker->randomElement([15000000, 20000000, 25000000, 30000000]);

        return [
            'category_id' => $this->faker->numberBetween(1, 4),
            'brand_id' => $this->faker->numberBetween(1, 4),
            'name' => ucwords($name),
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'sku' => 'PHONE-' . strtoupper(Str::random(6)),
            'price' => $price,
            'sale_price' => $price * 0.9, // Giảm giá 10%
            'stock_quantity' => $this->faker->numberBetween(10, 100),
            'description' => $this->faker->paragraphs(3, true),
            'thumbnail' => 'https://dummyimage.com/600x600/dee2e6/6c757d.jpg&text=Phone',
            'is_featured' => $this->faker->boolean(20), // 20% cơ hội là sản phẩm nổi bật
            'is_active' => true,
        ];
    }
}
