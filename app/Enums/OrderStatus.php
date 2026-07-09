<?php

namespace App\Enums;

class OrderStatus
{
    public static function canTransition(string $currentStatus, string $newStatus): bool
{
    // Ví dụ: Logic nghiệp vụ cho phép đơn đang pending chuyển sang completed hoặc canceled
    $allowedTransitions = [
        'pending'   => ['completed', 'canceled'],
        'completed' => [], // Không được chuyển đi đâu nữa
        'canceled'  => [], // Đã hủy rồi không được chuyển đi đâu nữa
    ];

    // Kiểm tra xem trạng thái mới có nằm trong danh sách được phép chuyển không
    return in_array($newStatus, $allowedTransitions[$currentStatus] ?? []);
}
}
