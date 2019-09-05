<?php

namespace App\DataTables;

use App\Club;
use App\Record;
use App\Student;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class RecordsDataTable extends DataTable
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
            ->editColumn('student_nid', function (Record $record) {
                return view('record.datatables.student', compact('record'))->render();
            })
            ->filterColumn('student_nid', function ($query, $keyword) {
                /* @var Builder|Record $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('club_id', function (Record $record) {
                return view('record.datatables.club', compact('record'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Record $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Club $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('web_scan', function (Record $record) {
                return $record->web_scan ? 'O' : 'X';
            })
            ->rawColumns(['student_nid', 'club_id']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Record $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(Record $model)
    {
        return $model->newQuery()->with('student', 'club.clubType')->select(array_keys($this->getColumns()));
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
            'club_id'     => ['title' => '社團'],
            'ip'          => ['title' => '打卡IP'],
            'created_at'  => ['title' => '打卡時間'],
            'web_scan'    => [
                'title'      => 'WebScan',
                'searchable' => false,
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
        return 'records_' . time();
    }
}
