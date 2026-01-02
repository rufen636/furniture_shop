<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'price_from',
        'price_to',
    ];

    protected function title(Builder $builder, $value)
    {
        return $builder->where('title', 'like', "%$value%");
    }
    protected function priceFrom(Builder $builder,$value)
    {
        return $builder->where('price', '>=', "%$value%");
    }
    protected function priceTo(Builder $builder,$value)
    {
        return $builder->where('price', '<=', "%$value%");
    }
}
