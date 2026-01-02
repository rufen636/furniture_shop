<?php

namespace App\Services\Admin\Product;

use App\Models\Parameters;
use App\Services\Admin\Image\ImageService;

class ParamService
{
    protected $imageService;
    public function __construct(ImageService $imageService){
        $this->imageService = $imageService;
    }
    public function store($product,$data)
    {
        foreach ($data as $key => $value){
            $param = Parameters::create([
                'product_id' => $product->id,
                'width' =>  $value['width'],
                'height' =>  $value['height'],
                'color_id' =>  $value['color_id'],
            ]);
            $this->imageService->store($param, $value['images_path']);
        }
    }
}
