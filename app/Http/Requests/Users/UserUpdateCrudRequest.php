<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateCrudRequest extends FormRequest
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
        $id = $this->get('id') ?? request()->route('id');
        // 'phone' => 'max:20|unique:' . config('permission.table_names.users', 'users') . ',phone,' . $id,
        return [
            'email' => 'required|unique:' . config('permission.table_names.users', 'users') . ',email,' . $id,
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'password' => 'sometimes|nullable|min:6|max:20|confirmed',
            'phone' => 'max:20',
            'address' => 'max:255',
            'school' => 'max:50',
        ];
    }
}
