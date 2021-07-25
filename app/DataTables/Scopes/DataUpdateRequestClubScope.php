<?php

namespace App\DataTables\Scopes;

use App\Models\Club;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Contracts\DataTableScope;

class DataUpdateRequestClubScope implements DataTableScope
{
    /**
     * @var Club
     */
    private $club;

    /**
     * DataUpdateRequestClubScope constructor.
     * @param Club $club
     */
    public function __construct(Club $club)
    {
        $this->club = $club;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return $query->where('club_id', $this->club->id);
    }
}
