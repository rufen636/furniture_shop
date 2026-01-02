<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
