<?php

namespace App\DataTables;

use App\Feedback;
use Illuminate\Database\Query\Builder;
use Yajra\Datatables\Services\DataTable;

class FeedbackDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\Datatables\Engines\BaseEngine
     */
    public function dataTable()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'feedback.datatables.action')
            ->editColumn('student_id', function ($feedback) {
                return view('feedback.datatables.student', compact('feedback'))->render();
            })
            ->filterColumn('student_id', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereIn('student_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('students.id')
                        ->from('students')
                        ->join('feedback', 'students.id', '=', 'student_id')
                        ->whereRaw('students.name LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('students.nid LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->addColumn('is_freshman', function ($feedback) {
                /** @var Feedback $feedback */
                return view('feedback.datatables.is_freshman', compact('feedback'))->render();
            })
            ->editColumn('club_id', function ($feedback) {
                return view('feedback.datatables.club', compact('feedback'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereIn('club_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('clubs.id')
                        ->from('clubs')
                        ->join('feedback', 'clubs.id', '=', 'club_id')
                        ->whereRaw('clubs.name LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        /** @var Feedback|\Illuminate\Database\Eloquent\Builder $query */
        $query = Feedback::with('student', 'club.clubType');

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax('')
            ->addAction(['title' => '操作'])
            ->parameters([
                'order'      => [[0, 'asc']],
                'pageLength' => 50,
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id'          => ['title' => '#'],
            'student_id'  => ['title' => '學生'],
            'is_freshman' => [
                'searchable' => false,
                'orderable'  => false,
                'title'      => '新生',
            ],
            'club_id'     => ['title' => '社團'],
            'phone'       => ['title' => '電話'],
            'email'       => ['title' => '信箱'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'feedback_' . time();
    }
}
