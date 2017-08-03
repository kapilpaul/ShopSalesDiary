<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockAddRequest extends FormRequest
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
            'product_id' => 'required|numeric',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'paid' => 'numeric',
            'due' => 'numeric',
            'date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Please select a Product',
            'product_id.numeric' => 'Invaid Product',
            'buying_price.required'  => 'Please Enter a buying price',
            'buying_price.numeric'  => 'Invalid Buying Price',
            'selling_price.required'  => 'Please Enter a selling price',
            'selling_price.numeric'  => 'Invalid Selling Price',
            'quantity.required'  => 'Please Enter product quantity',
            'quantity.numeric'  => 'Invalid quantity',
            'paid.numeric'  => 'Invalid paid amount',
            'due.numeric'  => 'Invalid due amount',
            'date.required'  => 'Please enter date',
            'date.date'  => 'Invalid Date Format',
        ];
    }


}
