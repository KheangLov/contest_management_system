<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestRequest extends FormRequest
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
        if (request()->has('ignore_validation') && request()->ignore_validation) {
            return [];
        }

        return [
            'title' => 'required|max:255',
            'title_kh' => 'sometimes|max:255',
            'level' => 'required|integer|exists:levels,id',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'duration' => 'required',
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
