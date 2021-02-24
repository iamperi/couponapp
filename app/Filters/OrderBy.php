<?php

namespace App\Filters;

class OrderBy extends Filter
{
    protected function applyFilter($builder)
    {
        $filterName = $this->filterName();
        $orderBy = request($this->filterName());

        if(str_contains($filterName, '.')) {
            $splits = explode('.', $filterName);
            $relatedModel = $splits[0];
            $relatedField = $splits[1];

            $orderBy = "$relatedModel.$relatedField";
        }

        return $builder->orderBy($orderBy, request('order_asc') == 'true' ? 'asc' : 'desc');
    }
}
