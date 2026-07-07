<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $adminId = $this->route('admin');
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $adminId,
            'password' => 'nullable|string|min:6|confirmed', // Cho phép null
            'is_active' => 'nullable|boolean',
        ];
    }
}
