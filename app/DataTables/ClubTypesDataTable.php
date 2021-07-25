<?php

namespace App\DataTables;

use App\Models\ClubType;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class ClubTypesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'club-type.datatables.action')
            ->editColumn('name', 'club-type.datatables.name')
            ->editColumn('is_counted', 'club-type.datatables.is_counted')
            ->rawColumns(['name', 'is_counted', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param ClubType $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|Collection
     */
    public function query(ClubType $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
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
            'id'         => ['title' => '#'],
            'name'       => ['title' => '名稱'],
            'is_counted' => ['title' => '是否列入抽獎集點'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'clubtypes_' . time();
    }
}
