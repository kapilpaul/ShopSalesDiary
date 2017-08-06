<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSellsRequest extends FormRequest
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
            'phone_no' => 'required|min:11',
            'email' => 'email',
            'stock_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'discount' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Customer name Cannot be Empty',
            'phone_no.required' => 'Phone No Required',
            'phone_no.min' => 'Phone No Must be 11 Digits',
            'email.email'  => 'Please Enter a valid email address',
            'stock_id.required'  => 'Please select a product',
            'stock_id.numeric'  => 'Invalid Stock Selected',
            'quantity.required'  => 'Quantity is required',
            'quantity.numeric'  => 'Invalid Quantity. Must be Numeric',
            'discount.numeric'  => 'Invalid Discount. Must be Numeric',
        ];
    }
}
