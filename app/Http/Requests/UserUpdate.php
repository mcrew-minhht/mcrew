<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
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
        $this->redirect = route('user_update_error', ['id' => $requests->id]);

        return [
            'id' => 'required',

            'name' => 'bail|required|between:0,255',
            'email' => 'bail|required|email|between:0,255'. ($requests->id ? '|unique:users,email,'.$requests->id : ''),
            'birthday' => 'date|nullable',
            'identity' => 'between:0,10',
            'identity_date' => 'date|nullable',
            'identity_place' => 'between:0,255',
            'phone_number' => 'between:0,11',
            'current_address' => 'between:0,255',
            'regularly_address' => 'between:0,255',
            'file'=> 'nullable|mimes:pdf'
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
