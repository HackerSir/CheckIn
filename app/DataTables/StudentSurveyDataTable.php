<?php

namespace App\DataTables;

use App\Models\Student;
use App\Models\StudentSurvey;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class StudentSurveyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'student-survey.datatables.action')
            ->editColumn('student_nid', function (StudentSurvey $studentSurvey) {
                return view('student-survey.datatables.student', compact('studentSurvey'))->render();
            })
            ->filterColumn('student_nid', function ($query, $keyword) {
                /* @var Builder|StudentSurvey $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('is_freshman', function (StudentSurvey $studentSurvey) {
                return view('student-survey.datatables.is_freshman', compact('studentSurvey'))->render();
            })
            ->editColumn('comment', function (StudentSurvey $studentSurvey) {
                return view('student-survey.datatables.comment', compact('studentSurvey'))->render();
            })
            ->rawColumns(['is_freshman', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param  StudentSurvey  $model
     * @return \Illuminate\Database\Eloquent\Builder|Builder|Collection
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
            'student_nid' => ['title' => '學生'],
            'is_freshman' => [
                'searchable' => false,
                'orderable'  => false,
                'title'      => '新生',
            ],
            'rating'      => ['title' => '評價'],
            'comment'     => ['title' => '意見與建議'],
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
