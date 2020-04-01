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
        $this->redirect = '/users/search';
        return [
            'name' => 'between:0,255',
            'email' => 'nullable|email|between:0,255',
            'birthday' => 'date|nullable',
            'identity' => 'between:0,10',
            'identity_date' => 'date|nullable',
            'identity_place' => 'between:0,255',
            'phone_number' => 'between:0,11',
            'current_address' => 'between:0,255',
            'regularly_address' => 'between:0,255',
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
