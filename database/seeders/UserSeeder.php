<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tài khoản Quản trị viên (Admin)
        User::create([
            'name' => 'Admin Nam Khuê',
            'email' => 'admin@namkhue.com',
            'password' => Hash::make('12345678'), // Mật khẩu: 12345678
            'phone' => '0901234567',
            'address' => 'Tổng kho A, TP.HCM',
            'is_active' => true,
        ]);

        // 2. Tài khoản Khách hàng sỉ số 1
        User::create([
            'name' => 'Nguyễn Văn Đại Lý',
            'email' => 'daily1@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0911111111',
            'address' => 'Cửa hàng Phụ kiện Quận 1, TP.HCM',
            'is_active' => true,
        ]);

        // 3. Tài khoản Khách hàng sỉ số 2 (Đang bị khóa để test bộ lọc)
        User::create([
            'name' => 'Trần Thị Bán Buôn',
            'email' => 'banbuon2@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0922222222',
            'address' => 'Kho phân phối sỉ Đà Nẵng',
            'is_active' => false, // Set false để ông test giao diện trạng thái (Hoạt động / Khóa)
        ]);

        $this->command->info('🔥 Đã tạo thành công 3 User. Mật khẩu chung là: 12345678');
    }
}
