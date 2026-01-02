<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class  AbstractFilter
{
    protected array $keys = [];
    protected function apply(Builder $builder, array $filers)
    {
        foreach ($this->keys as $key) {
            if (isset($filers[$key])) {
                $method = Str::camel($key);
                $this->$method(($builder));
            }
        }
        return $builder;
    }
}
