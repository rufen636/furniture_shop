<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductParamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'color_id'=> $this->color_id,
            'width'=> $this->width,
            'height'=> $this->height,
            'images'=> ProductImageResource::collection($this->images)->resolve(),
        ];
    }
}
