<?php

namespace App\Filters;

class Search extends Filter
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    protected function applyFilter($builder)
    {
        $filterName = $this->filterName();
        $search = request($this->filterName());

        $builder = $builder->where(function($query) use ($search) {
            $query->where($this->fields[0], 'like', "%$search%");
            for($i = 1; $i < count($this->fields); $i++) {
                $query->orWhere($this->fields[$i], 'like', "%$search%");
            }
        });
        return $builder;
    }
}
