<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Chỉ định rõ các trường được phép Insert/Update (Chống Mass Assignment)
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_active',
    ];

    // Che giấu các dữ liệu nhạy cảm khi Model được parse sang JSON (Tính Đóng gói)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tự động ép kiểu dữ liệu từ DB lên App
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Quan hệ 1-N: Một User có nhiều Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
