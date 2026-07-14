<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Thực thi cập nhật cấu trúc bảng.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thay đổi tên cột từ sale_price thành wholesale_price
            // Lưu ý: Nếu ông dùng Laravel bản cũ (dưới 10.x), ông cần chạy lệnh: composer require doctrine/dbal trước khi rename
            $table->renameColumn('sale_price', 'wholesale_price');

            // Tùy chọn nâng cấp: Đồng bộ kiểu dữ liệu (Nếu cần)
            // Cột price của ông đang là DECIMAL(15,2), cột sỉ đang là (12,2).
            // Nếu muốn đồng bộ, ông có thể bật dòng dưới:
            // $table->decimal('wholesale_price', 15, 2)->nullable()->change();
        });
    }

    /**
     * Hoàn tác khi rollback.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('wholesale_price', 'sale_price');
        });
    }
};
