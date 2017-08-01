<?php

namespace App\DataTables;

use App\ClubType;
use Yajra\Datatables\Services\DataTable;

class ClubTypesDataTable extends DataTable
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
            ->addColumn('action', 'club-type.datatables.action')
            ->editColumn('name', 'club-type.datatables.name')
            ->editColumn('is_counted', 'club-type.datatables.is_counted')
            ->escapeColumns([]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        /** @var ClubType|\Illuminate\Database\Eloquent\Builder $query */
        $query = ClubType::query();

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
