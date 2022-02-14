<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // 'phone' => 'max:20|unique:' . config('permission.table_names.users', 'users') . ',phone',
        return [
            'email' => 'required|unique:'.config('permission.table_names.users', 'users').',email',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'password' => 'required|min:6|max:20|confirmed',
            'phone' => 'max:20',
            'address' => 'max:255',
            'school' => 'max:50',
        ];
    }
}
