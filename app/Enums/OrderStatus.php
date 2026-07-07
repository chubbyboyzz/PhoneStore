<?php

namespace App\Enums;

class OrderStatus
{
    const PENDING = 1;     // Chờ xác nhận
    const PROCESSING = 2;  // Đang chuẩn bị hàng
    const SHIPPING = 3;    // Đang giao hàng
    const DELIVERED = 4;   // Đã giao thành công
    const CANCELLED = 5;   // Đã hủy

    /**
     * Thuật toán kiểm tra tính hợp lệ của luồng chuyển đổi trạng thái
     */
    public static function canTransition(int $currentStatus, int $newStatus): bool
    {
        // Fail-Fast: Đơn đã Hủy hoặc Giao thành công thì không được phép thay đổi nữa
        if (in_array($currentStatus, [self::DELIVERED, self::CANCELLED])) {
            return false;
        }

        // Logic tiến lên: Trạng thái mới phải lớn hơn trạng thái cũ (Trừ trường hợp Hủy)
        if ($newStatus === self::CANCELLED) {
            return true;
        }

        return $newStatus > $currentStatus;
    }
}
