<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart' => 'required',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|min:11|max:13',
            'customer_email' => 'required|email',
            'customer_address' => 'required|string',
            'customer_city' => 'required|string',
            'customer_country' => 'required|string',
        ];
    }
}
