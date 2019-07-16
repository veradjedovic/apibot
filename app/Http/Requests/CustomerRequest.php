<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:customers',
            'street' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'The First Name field is required!',
            'first_name.min' => 'The First Name field must contain at least 2 characters!',
            'first_name.max' => 'The First Name field must contain a maximum of 255 characters!',
            'last_name.required' => 'The Last Name field is required!',
            'last_name.min' => 'The Last Name field must contain at least 2 characters!',
            'last_name.max' => 'The Last Name field must contain a maximum of 255 characters!',
            'email.required' => 'The Email field is required!',
            'email.unique' => 'Each customer must have a unique email address!',
            'street.required' => 'The street field is required!',
            'street.min' => 'The street field must contain at least 2 characters!',
            'street.max' => 'The street field must contain a maximum of 255 characters!',
            'country.required' => 'The country field is required!',
            'country.min' => 'The country field must contain at least 2 characters!',
            'country.max' => 'The country field must contain a maximum of 255 characters!',
        ];
    }
}
