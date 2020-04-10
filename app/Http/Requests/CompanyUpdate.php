<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdate extends FormRequest
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
    public function rules(Request $requests)
    {
        $this->redirect = route('detailCompany', ['id' => $requests->id]);

        return [
            'id' => 'required',

            'name' => 'bail|required|between:0,255',
            'email' => 'bail|required|email|between:0,255'. ($requests->id ? '|unique:users,email,'.$requests->id : ''),
            'phone' => 'required|numeric',
            'address' => 'required',
            'bank_name' => 'required',
            'bank_number' => 'required',
            'bank_account_name' => 'required'
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
