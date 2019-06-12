<?php

namespace App\DataTables;

use App\Club;
use App\Feedback;
use App\Student;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class FeedbackDataTable extends DataTable
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
            ->addColumn('action', 'feedback.datatables.action')
            ->editColumn('student_nid', function (Feedback $feedback) {
                return view('feedback.datatables.student', compact('feedback'))->render();
            })
            ->filterColumn('student_nid', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('is_freshman', function (Feedback $feedback) {
                /** @var Feedback $feedback */
                return view('feedback.datatables.is_freshman', compact('feedback'))->render();
            })
            ->editColumn('club_id', function (Feedback $feedback) {
                return view('feedback.datatables.club', compact('feedback'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Club $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->rawColumns(['is_freshman', 'club_id', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Feedback $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(Feedback $model)
    {
        return $model->newQuery()->with('student', 'club.clubType');
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
            'club_id'     => ['title' => '社團'],
            'phone'       => ['title' => '電話'],
            'email'       => ['title' => '信箱'],
            'facebook'    => ['title' => 'Facebook'],
            'line'        => ['title' => 'LINE'],
            'message'     => [
                'searchable' => false,
                'orderable'  => false,
                'title'      => '訊息',
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
        return 'feedback_' . time();
    }
}
