<?php

namespace App\DataTables;

use App\ClubSurvey;
use App\Feedback;
use App\Student;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ClubSurveyDataTable extends DataTable
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
            ->addColumn('action', 'club-survey.datatables.action')
            ->editColumn('user_id', function (ClubSurvey $clubSurvey) {
                return view('club-survey.datatables.user', compact('clubSurvey'))->render();
            })
            ->filterColumn('user_id', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereHas('user', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('club_id', function (ClubSurvey $clubSurvey) {
                return view('club-survey.datatables.club', compact('clubSurvey'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('comment', function ($clubSurvey) {
                return view('club-survey.datatables.comment', compact('clubSurvey'))->render();
            })
            ->rawColumns(['club_id', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param ClubSurvey $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(ClubSurvey $model)
    {
        return $model->newQuery()->with('user', 'club.clubType');
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
            'id'      => ['title' => '#'],
            'user_id' => ['title' => '使用者'],
            'club_id' => ['title' => '社團'],
            'rating'  => ['title' => '評價'],
            'comment' => ['title' => '意見與建議'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'clubsurvey_' . time();
    }
}
