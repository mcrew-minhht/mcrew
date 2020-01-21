<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSearch extends FormRequest
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
            'name' => 'between:0,255',
            'email' => 'bail|between:0,255|unique:users,email',
            'password' => 'between:0,255',
            'birthday' => 'date|nullable',
            'identity' => 'between:0,10|nullable',
            'identity_date' => 'date|nullable',
            'identity_place' => 'between:0,255|nullable',
            'phone_number' => 'between:0,10|nullable',
            'current_address' => 'between:0,255|nullable',
            'regularly_address' => 'between:0,255|nullable',
            'join_company_date' => 'date|nullable',
            'company_staff_date' => 'date|nullable',
            'role' => 'digits_between:1,2',
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
            //
        ];
    }
}
