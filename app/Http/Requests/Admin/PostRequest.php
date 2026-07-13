<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'   => 'required|max:255',
            'content' => 'required',
            'status'  => 'required|in:draft,published',
            // Validate mảng ảnh: tối đa 4 file, định dạng chuẩn web, tối đa 2MB
            'images'   => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
