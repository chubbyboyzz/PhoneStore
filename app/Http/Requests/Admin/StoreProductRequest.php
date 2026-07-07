<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */


    /**
     * Khai báo các quy tắc (Rules) theo chuẩn nghiệp vụ
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Tùy biến câu thông báo lỗi (Tùy chọn, để thân thiện với người dùng)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'name.unique' => 'Tên sản phẩm này đã tồn tại trong hệ thống.',
            'price.min' => 'Giá bán không hợp lệ.',
        ];
    }
}
