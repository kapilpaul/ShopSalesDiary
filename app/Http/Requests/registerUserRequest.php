<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles_id' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'photo_id' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please Enter your Name',
            'email.required'  => 'Please Enter an Email address',
            'email.email'  => 'Please Enter a valid Email address',
            'email.unique'  => 'Email should be unique',
            'roles_id.required' => 'Please Select a Role',
            'roles_id.numeric' => 'Do not change the value of Role',
            'password.required'  => 'Please Enter a password',
            'password.min'  => 'Password must be 6 Characters',
            'password.confirmed'  => 'Pasword Not matched',
            'photo_id.image'  => 'You can Only Upload Jpg, jpeg, png image',
        ];
    }
}
