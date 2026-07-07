<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
        $table->foreignId('brand_id')->constrained('brands')->onDelete('restrict');

        $table->string('name');
        $table->string('slug')->unique();
        $table->string('sku', 50)->unique();
        $table->decimal('price', 12, 2);
        $table->decimal('sale_price', 12, 2)->nullable();
        $table->integer('stock_quantity')->default(0);
        $table->longText('description')->nullable();
        $table->string('thumbnail');

        // Hỗ trợ mảng SEO & Hiển thị
        $table->boolean('is_featured')->default(false); // Sản phẩm nổi bật
        $table->integer('views')->default(0); // Lượt xem
        $table->boolean('is_active')->default(true);
        $table->timestamps();

        // Đánh Index tối ưu tốc độ Filter
        $table->index(['category_id', 'brand_id', 'is_active']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
