<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountInfoRequest extends FormRequest
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
     * Restrict the fields that the user can change.
     *
     * @return array
     */
    public function validationData()
    {
        return $this->only(backpack_authentication_column(), 'first_name', 'last_name');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = backpack_user()->id;

        return [
            'email' => 'required|unique:' . config('permission.table_names.users', 'users') . ',email,' . $id,
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
        ];
    }
}
