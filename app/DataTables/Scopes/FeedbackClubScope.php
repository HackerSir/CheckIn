<?php

namespace App\DataTables\Scopes;

use App\Models\Club;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Contracts\DataTableScope;

class FeedbackClubScope implements DataTableScope
{
    /**
     * @var Club
     */
    private $club;

    /**
     * FeedbackFilterScope constructor.
     * @param Club $club
     */
    public function __construct(Club $club = null)
    {
        $this->club = $club;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|Builder|Feedback $query
     * @return mixed
     */
    public function apply($query)
    {
        $query->where('club_id', $this->club->id)
            ->where(function ($query) {
                /** @var Builder|Feedback $query */
                $query->where('join_club_intention', '<>', 0)
                    ->orWhere('join_tea_party_intention', '<>', 0);
            });

        return $query;
    }
}
