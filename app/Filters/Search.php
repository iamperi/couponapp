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
            for($i = 1; $i < count($this->fields); $i++) {
                $field = $this->fields[$i];
                if(str_contains($field, '.')) {
                    $relatedTable = explode('.', $field)[0];
                    $relatedColumn = explode('.', $field)[1];
                    if($i == 0) {
                        $query->whereHas($relatedTable, function ($q) use ($relatedColumn, $search) {
                            $q->where($relatedColumn, 'like', "%$search%");
                        });
                    } else {
                        $query->orWhereHas($relatedTable, function ($q) use ($relatedColumn, $search) {
                            $q->where($relatedColumn, 'like', "%$search%");
                        });
                    }
                } else {
                    if($i == 0) {
                        $query->where($field, 'like', "%$search%");
                    } else {
                        $query->orWhere($this->fields[$i], 'like', "%$search%");
                    }
                }
            }
        });
        return $builder;
    }
}
