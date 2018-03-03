<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|max:100',
            'role' => 'nullable',
            'role_description' => 'nullable',
            'email' => 'required',
            'phone' => 'required',
            'photo' => 'nullable'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Members name is required',
            'name.max' => 'Members name less must not exceed 100 chars',
            'email.required'  => 'Members email is required',
            'phone.required'  => 'Members phone number is required'
        ];
    }
}
