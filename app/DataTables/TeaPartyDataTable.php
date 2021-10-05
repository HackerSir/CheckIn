<?php

namespace App\DataTables;

use App\Models\Feedback;
use App\Models\Student;
use App\Models\TeaParty;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class TeaPartyDataTable extends DataTable
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
            ->editColumn('club_id', function (TeaParty $teaParty) {
                return view('tea-party.datatables.club', compact('teaParty'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('name', 'tea-party.datatables.name')
            ->editColumn('url', 'tea-party.datatables.url')
            ->rawColumns(['club_id', 'name', 'url']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  TeaParty  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TeaParty $model)
    {
        return $model->newQuery()->select('club_id', 'name', 'start_at', 'end_at', 'location', 'url');
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
            ->minifiedAjax()
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'order'      => [[2, 'desc']],
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
            'club_id'  => ['title' => '社團'],
            'name'     => ['title' => '茶會名稱'],
            'start_at' => ['title' => '開始時間'],
            'end_at'   => ['title' => '結束時間'],
            'location' => ['title' => '地點'],
            'url'      => ['title' => '網址', 'class' => 'text-break'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TeaParty_' . date('YmdHis');
    }
}
