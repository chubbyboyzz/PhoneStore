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
        // SỬA DÒNG NÀY THÀNH TRUE
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
            'brand_id' => 'required|integer|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
