<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

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
            'product.name' => 'required|string',
            'product.description' => 'nullable|string',
            'product.short_description' => 'nullable|string',
            'product.price' => 'required|numeric',
            'product.discount_price' => 'nullable|numeric',
            'product.quantity' => 'required|integer',
            'product.weight' => 'nullable|numeric',
            'product.is_active' => 'nullable|string',
            'product.views' => 'nullable|integer',
            'product.category_id' => 'nullable|integer',
            'product.brand_id' => 'nullable|integer',
            'product.parameters' => 'nullable|array',
            'product.parameters.*.color_id' => 'nullable|string',
            'product.parameters.*.width' => 'nullable|string',
            'product.parameters.*.height' => 'nullable|string',
            'product.parameters.*.images' => 'nullable|array',
        ];
    }

    public function passedValidation()
    {
        $paramsWithImages = [];

        foreach ($this->product['parameters'] as $index => $parameter) {
            $imageArray = [];

            if (isset($parameter['images'])) {
                foreach ($parameter['images'] as $image) {
                    $item = Storage::disk('public')->put('/images', $image['file']);
                    $imageArray[] = $item;
                }
            }

            // Добавляем путь к изображениям к конкретному параметру
            $paramsWithImages[$index] = [
                ...$parameter,
                'images_path' => $imageArray
            ];
        }

        $productData = $this->validated()['product'];

        if (isset($productData['is_active'])) {
            $productData['is_active'] = (boolean)$productData['is_active'];
        }

        return $this->merge([
            'product' => [
                ...$productData,
            ],
            'params' => $paramsWithImages,
            'user_id' => auth()->user()->id,
        ]);
    }
}
