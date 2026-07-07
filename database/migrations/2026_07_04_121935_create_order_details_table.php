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
    Schema::create('order_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');

        $table->string('product_name');
        $table->string('product_sku', 50)->nullable();

        // Lưu phân loại (Màu sắc, dung lượng) bằng JSON
        $table->json('variant_attributes')->nullable();
        // Lưu danh sách IMEI tương ứng số lượng xuất kho
        $table->json('imei_codes')->nullable();

        $table->integer('quantity');
        $table->decimal('unit_price', 12, 2);

        // MySQL tự động tính thành tiền, không cần PHP can thiệp
        $table->decimal('line_total', 12, 2)->storedAs('unit_price * quantity');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     Schema::dropIfExists('order_details');
    }

};
