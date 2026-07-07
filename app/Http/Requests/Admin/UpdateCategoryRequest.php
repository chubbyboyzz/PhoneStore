<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Trích xuất ID của danh mục đang thao tác từ tham số trên URL
        $categoryId = $this->route('category');

        return [
            // Cú pháp ignore ID: unique:table,column,except,idColumn
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
