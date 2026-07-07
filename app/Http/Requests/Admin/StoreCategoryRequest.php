<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Mở chốt chặn bảo mật mặc định để cho phép Request thực thi
        return true;
    }

    /**
     * Quy tắc kiểm duyệt dữ liệu đầu vào
     */
    public function rules(): array
    {
        return [
            // Tên danh mục bắt buộc nhập, không quá 255 ký tự và không được trùng trong bảng categories
            'name' => 'required|string|max:255|unique:categories,name',
            // Thứ tự sắp xếp phải là số nguyên, tối thiểu là số 0
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Tùy biến thông báo lỗi tiếng Việt
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục này đã tồn tại trên hệ thống.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là một con số.',
        ];
    }
}
