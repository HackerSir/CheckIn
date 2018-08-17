<?php

namespace App\DataTables;

use App\Student;
use App\StudentSurvey;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class StudentSurveyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'student-survey.datatables.action')
            ->editColumn('student_id', function ($studentSurvey) {
                return view('student-survey.datatables.student', compact('studentSurvey'))->render();
            })
            ->filterColumn('student_id', function ($query, $keyword) {
                /* @var Builder|StudentSurvey $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('is_freshman', function ($studentSurvey) {
                /** @var StudentSurvey $studentSurvey */
                return view('student-survey.datatables.is_freshman', compact('studentSurvey'))->render();
            })
            ->editColumn('comment', function ($studentSurvey) {
                return view('student-survey.datatables.comment', compact('studentSurvey'))->render();
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param StudentSurvey $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(StudentSurvey $model)
    {
        return $model->newQuery()->with('student');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax('')
            ->addAction(['title' => '操作'])
            ->parameters([
                'order'      => [[0, 'desc']],
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
            'rating'      => ['title' => '評價'],
            'comment'     => [
                'searchable' => false,
                'orderable'  => false,
                'title'      => '意見與建議',
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'studentsurvey_' . time();
    }
}
