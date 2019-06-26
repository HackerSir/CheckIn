<?php

namespace App\DataTables;

use App\Booth;
use App\Club;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class BoothsDataTable extends DataTable
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
            ->editColumn('name', 'booth.datatables.name')
            ->editColumn('club_id', function (Booth $booth) {
                return view('booth.datatables.club', compact('booth'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Booth $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Club $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->rawColumns(['name', 'club_id']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Booth $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(Booth $model)
    {
        return $model->newQuery()->with('club')->select(array_keys($this->getColumns()));
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
            'id'        => ['title' => '#'],
            'name'      => ['title' => '攤位編號'],
            'club_id'   => ['title' => '社團'],
            'longitude' => ['title' => '經度'],
            'latitude'  => ['title' => '緯度'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'booths_' . time();
    }
}
