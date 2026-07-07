<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Bỏ qua phân quyền ở mức Request vì đã có Middleware bọc ngoài Route
    }

    public function rules(): array
    {
        return [
            // Ràng buộc cốt lõi: user_id bắt buộc phải có và phải khớp với id trong bảng users
            'user_id' => 'required|integer|exists:users,id',

            // Tạm thời giả lập giá trị tổng tiền cho đơn hàng tạo tay
            'total_price' => 'required|numeric|min:0',

            // Trạng thái đơn hàng khởi tạo mặc định phải hợp lệ (VD: 1 - Pending)
            'status' => 'required|integer|in:1,2,3,4,5',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Bắt buộc phải chọn khách hàng cho đơn hàng này.',
            'user_id.exists' => 'Tài khoản khách hàng không tồn tại trên hệ thống.',
        ];
    }
}
