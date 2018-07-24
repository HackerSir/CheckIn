<?php

namespace App\DataTables;

use App\QrcodeSet;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class QrcodeSetsDataTable extends DataTable
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
            ->addColumn('action', 'qrcode-set.datatables.action');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param QrcodeSet $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(QrcodeSet $model)
    {
        return $model->newQuery()->withCount('qrcodes');
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
            'id'            => ['title' => '#'],
            'qrcodes_count' => [
                'searchable' => false,
                'title'      => 'QR Code 數量',
            ],
            'created_at'    => ['title' => '建立時間'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'qrcodesets_' . time();
    }
}
