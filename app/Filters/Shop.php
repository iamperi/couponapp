<?php

namespace App\Filters;

use Closure;

class Shop extends Filter
{
    protected function applyFilter($builder)
    {
        if(!empty(request($this->filterName()))) {
            return $builder->where('shop_id', request($this->filterName()));
        }
        return $builder;
    }
}
