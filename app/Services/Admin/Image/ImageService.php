<?php

namespace App\Services\Admin\Image;

use App\Models\Image;

class ImageService
{

    public function store($model, $paths)
    {
        if ($model && is_array($paths)) {
            foreach ($paths as $path) {
                Image::create([
                    'imageable_type' => get_class($model),
                    'imageable_id' => $model->id,
                    'small_uri' => $path,
                    'big_uri' => $path,
                ]);
            }
        } else {
            Image::create([
                'imageable_type' => get_class($model),
                'imageable_id' => $model->id,
                'small_uri' => $paths,
                'big_uri' => $paths,
            ]);
        }
    }
}
