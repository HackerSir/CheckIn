<?php

namespace App\DataTables\Scopes;

use App\Models\Club;
use App\Models\Feedback;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Contracts\DataTableScope;

class FeedbackFilterScope implements DataTableScope
{
    /**
     * @var Club
     */
    private $club;
    /**
     * @var Student
     */
    private $student;

    /**
     * FeedbackFilterScope constructor.
     * @param Club $club
     * @param Student $student
     */
    public function __construct(Club $club = null, Student $student = null)
    {
        $this->club = $club;
        $this->student = $student;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|Builder|Feedback $query
     * @return mixed
     */
    public function apply($query)
    {
        if ($this->club && $this->student) {
            $query->where('club_id', $this->club->id)
                ->orWhere('student_nid', $this->student->nid);
        } elseif ($this->club) {
            $query->where('club_id', $this->club->id);
        } elseif ($this->student) {
            $query->where('student_nid', $this->student->nid);
        }

        return $query;
    }
}
