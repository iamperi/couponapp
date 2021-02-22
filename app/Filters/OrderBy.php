<?php

namespace App\Filters;

use Closure;

class OrderBy extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->orderBy(request($this->filterName()), request('order_asc') == 'true' ? 'asc' : 'desc');
    }
}
