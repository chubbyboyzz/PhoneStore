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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

        $table->string('order_code', 20)->unique(); // Mã đơn hàng ngắn gọn (VD: VN-12345) cho khách tra cứu
        $table->string('customer_name');
        $table->string('customer_phone', 20);
        $table->string('customer_address');

        $table->decimal('sub_total', 12, 2); // Tổng tiền hàng
        $table->decimal('shipping_fee', 12, 2)->default(0); // Phí ship
        $table->decimal('total_amount', 12, 2); // Tổng tiền cuối cùng

        $table->enum('payment_method', ['cod', 'vnpay', 'momo'])->default('cod');
        $table->boolean('is_paid')->default(false); // Trạng thái thanh toán
        $table->enum('status', ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'])->default('pending');

        $table->text('notes')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
