<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'material' => 'nullable|string',
            'color' => 'nullable|string',
            'style' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|double',
            'compare_price' => 'nullable|double',
            'cost_price' => 'nullable|double',
            'quantity' => 'required|integer',
            'weight' => 'nullable|double',
            'dimensions' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'views' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'brand_id' => 'nullable|integer',
        ];
    }
}
