<?php

namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter(Builder $builder, array $filters)
    {
        $class =  'App\\Http\\Filters' . class_basename(static::class) . 'Filter';
        if (class_exists($class)) {
            return (new $class)->apply($builder, $filters);
        }else{
            return response()->json(['error' => 'Filter not found'], 404);
        }
    }
}
