<?php

namespace App\DataTables;

use App\Models\ExtraTicket;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class ExtraTicketsDataTable extends DataTable
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
            ->addColumn('action', 'extra-ticket.datatables.action');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param  ExtraTicket  $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|Collection
     */
    public function query(ExtraTicket $model)
    {
        return $model->newQuery()->select(array_keys($this->getColumns()));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id'    => ['title' => '#'],
            'nid'   => ['title' => '學號'],
            'name'  => ['title' => '姓名'],
            'class' => ['title' => '系級'],
        ];
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
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'extratickets_' . time();
    }
}
