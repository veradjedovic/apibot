<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'order_amount' => 'required|numeric',
            'shipping_amount' => 'numeric',
            'tax_amount' => 'numeric',
            'customer_id' => 'required|numeric'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'order_amount.required' => 'The order amount field is required!',
            'order_amount.numeric' => 'The order amount field must be numeric!',
            'shipping_amount.numeric' => 'The shipping amount field must be numeric!',
            'tax_amount.numeric' => 'The tax amount field must be numeric!',
            'customer_id.required' => 'The customer id field is required!',
            'customer_id.numeric' => 'The customer id field must be numeric!'
        ];
    }
}
