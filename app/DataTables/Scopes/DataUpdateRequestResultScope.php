<?php

namespace App\DataTables\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Contracts\DataTableScope;

class DataUpdateRequestResultScope implements DataTableScope
{
    /**
     * @var string
     */
    private $result;

    /**
     * DataUpdateRequestResultScope constructor.
     *
     * @param  string  $result
     */
    public function __construct(string $result)
    {
        $this->result = $result;
    }

    /**
     * Apply a query scope.
     *
     * @param  \Illuminate\Database\Query\Builder|Builder  $query
     * @return mixed
     */
    public function apply($query)
    {
        if ($this->result == 'wait') {
            return $query->whereNull('review_result');
        }
        if ($this->result == 'pass') {
            return $query->where('review_result', true);
        }
        if ($this->result == 'fail') {
            return $query->where('review_result', false);
        }

        return $query;
    }
}
