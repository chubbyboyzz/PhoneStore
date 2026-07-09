<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SystemTestDataSeeder extends Seeder
{
    /**
     * Chạy thuật toán nạp dữ liệu giả lập.
     */
    public function run(): void
    {
        // 1. KHỞI TẠO 3 TÀI KHOẢN KHÁCH HÀNG (Mock Users)
        // Sử dụng mảng đa chiều để quản lý cấu trúc dữ liệu chặt chẽ
        $customers = [
            [
                'name' => 'Trần Văn Alpha',
                'email' => 'alpha.khachhang@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0901111222',
            ],
            [
                'name' => 'Nguyễn Thị Beta',
                'email' => 'beta.khachhang@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0903333444',
            ],
            [
                'name' => 'Lê Hoàng Gamma',
                'email' => 'gamma.khachhang@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0905555666',
            ]
        ];

        $createdUsers = [];
        foreach ($customers as $customer) {
            // Dùng firstOrCreate để chạy Seeder nhiều lần không bị lỗi Duplicate Key
            $createdUsers[] = User::firstOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }

        // 2. KHỞI TẠO 3 ĐƠN HÀNG (Mock Orders) GẮN VỚI 3 KHÁCH HÀNG TRÊN
        // Cố tình setup 3 trạng thái (status) khác nhau để test bộ lọc UI (Máy trạng thái)
        $orders = [
            [
                'user_id' => $createdUsers[0]->id,
                'total_price' => 12500000, // 12.5 triệu
                'status' => 1, // PENDING - Chờ xác nhận (Test nhãn Xám)
                'created_at' => Carbon::now()->subDays(2), // Lùi lại 2 ngày để test hiển thị Date
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => $createdUsers[1]->id,
                'total_price' => 34900000, // 34.9 triệu
                'status' => 3, // SHIPPING - Đang giao hàng (Test nhãn Xanh biển)
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $createdUsers[2]->id,
                'total_price' => 590000, // 590k
                'status' => 5, // CANCELLED - Đã hủy (Test nhãn Đỏ và test xem có bị khóa logic sửa không)
                'created_at' => Carbon::now()->subMinutes(30),
                'updated_at' => Carbon::now(),
            ]
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        // In log ra console để Kỹ sư kiểm soát trạng thái
        $this->command->info('🔥 Khởi tạo thành công: 3 Khách hàng & 3 Đơn hàng giả lập!');
    }
}
