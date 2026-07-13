<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Cấp quyền cho Request được phép thực thi
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các quy tắc kiểm duyệt dữ liệu
     */
    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'name' => 'required|string|max:255|unique:products,name,' . $productId,
            'category_id' => 'required|integer|exists:categories,id',

            // Nới lỏng kiểm duyệt tương tự như luồng Store
            'brand_id' => 'required',

            // Validation thông minh chặn dữ liệu rỗng nếu Admin cố tình chọn tạo mới nhưng không nhập chữ
            'new_brand_name' => 'required_if:brand_id,NEW_BRAND|nullable|string|max:255',

            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
