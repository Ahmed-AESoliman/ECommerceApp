<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => "required|string|max:255",
            'description' => "required|string",
            'unit_price' => "required|decimal:1,2",
            'unit_discount' => "sometimes|decimal:1,2",
            'available_size' => "required|array",
            'available_colors' => "required|array",
            'unit_in_stock' => "required|min:1|integer",
            'unit_weight' => "sometimes|decimal:1,2",
            'category' => "required|exists:categories,id",
            'sub_category' => "sometimes|exists:categories,id",
            'attachments' => "required|array",
            'attachments.*' => "string",
        ];
    }
}
