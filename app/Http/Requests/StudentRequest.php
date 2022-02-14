<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        $email = 'required|unique:' . config('permission.table_names.users', 'users') . ',email';
        $phone = 'max:20';

        if ($id) {
            $email .= ",$id";
        }

        return [
            'email' => $email,
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => $phone,
            'address' => 'max:255',
            'school' => 'max:50',
            'dob' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
