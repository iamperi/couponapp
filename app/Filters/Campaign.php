<?php

namespace App\Filters;

class Campaign extends Filter
{
    protected function applyFilter($builder)
    {
        if(!empty(request($this->filterName()))) {
            return $builder->where('campaign_id', request($this->filterName()));
        }
        return $builder;
    }
}
