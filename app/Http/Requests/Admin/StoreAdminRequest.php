<?php

namespace App\Http\Requests\Admin;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // Trích xuất role của người đang thực hiện thao tác
        $currentUserRole = Auth::guard('admin')->user()->role;

        // Thuật toán xác định dải quyền được phép thao tác
        $allowedRoles = $currentUserRole === 'superadmin'
                        ? ['superadmin', 'manager', 'sales']
                        : ['manager', 'sales']; // Manager không thể gán quyền superadmin

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20|unique:admins,phone',
            // Ràng buộc Role phải nằm trong danh sách an toàn
            'role' => ['required', Rule::in($allowedRoles)],
            'is_active' => 'nullable|boolean',
        ];
    }
}
