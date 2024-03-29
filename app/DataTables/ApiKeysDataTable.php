<?php

namespace App\DataTables;

use App\Models\ApiKey;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class ApiKeysDataTable extends DataTable
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
            ->addColumn('action', 'api-key.datatables.action');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param  ApiKey  $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|Collection
     */
    public function query(ApiKey $model)
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
            'id'          => ['title' => '#'],
            'api_key'     => ['title' => 'API Key'],
            'count'       => ['title' => '使用次數'],
            'total_count' => ['title' => '總使用次數'],
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
        return 'apikeys_' . time();
    }
}
