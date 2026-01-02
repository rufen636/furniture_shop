<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use App\Services\Admin\Image\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CrudService
{
    protected $imageService;
    protected $paramService;
    public function __construct(ImageService $imageService, ParamService $paramService){
        $this->imageService = $imageService;
        $this->paramService = $paramService;
    }
    public function store($data)
    {
        unset($data['product']['parameters']);
        try {
            DB::beginTransaction();
            $product = Product::create($data['product']);
            $this->paramService->store($product,$data['params']);
            DB::commit();
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
        return $product;
    }
    public function update()
    {

    }
}
