<?php

namespace App\Services\Admin\Product;

use App\Models\Product;

class CrudService
{
    public function store($data)
    {
        return Product::create($data);
    }
}
