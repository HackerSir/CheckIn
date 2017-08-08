<?php

namespace App\DataTables\Scopes;

use App\Club;
use App\Feedback;
use App\Student;
use Yajra\Datatables\Contracts\DataTableScopeContract;

class FeedbackFilterScope implements DataTableScopeContract
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
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|Feedback $query
     * @return mixed
     */
    public function apply($query)
    {
        if ($this->club && $this->student) {
            $query->where('club_id', $this->club->id)
                ->orWhere('student_id', $this->student->id);
        } elseif ($this->club) {
            $query->where('club_id', $this->club->id);
        } elseif ($this->student) {
            $query->where('student_id', $this->student->id);
        }

        return $query;
    }
}
