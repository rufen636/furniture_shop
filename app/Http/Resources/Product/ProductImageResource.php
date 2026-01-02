<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'path' => $this->big_uri ? request()->getScheme() . '://' . request()->getHost() . (request()->getPort() ? ':' . request()->getPort() : '') . Storage::url($this->big_uri) : null
        ];
    }
}
