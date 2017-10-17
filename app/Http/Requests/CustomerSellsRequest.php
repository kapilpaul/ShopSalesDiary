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
            'stock_id' => 'required|array',
            'quantity' => 'required|array',
            'discount' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Customer name Cannot be Empty',
            'phone_no.required' => 'Phone No Required',
            'phone_no.min' => 'Phone No Must be 11 Digits',
            'stock_id.required'  => 'Please select a product',
            'stock_id.array'  => 'Invalid Stock Selected',
            'quantity.required'  => 'Quantity is required',
            'quantity.array'  => 'Invalid Quantity. Must be Array',
            'discount.numeric'  => 'Invalid Discount. Must be Numeric',
        ];
    }
}
