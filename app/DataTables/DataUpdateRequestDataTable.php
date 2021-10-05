<?php

namespace App\DataTables;

use App\Models\Club;
use App\Models\DataUpdateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class DataUpdateRequestDataTable extends DataTable
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
            ->addColumn('action', 'club.data-update-request.datatables.action')
            ->editColumn('club_id', function (DataUpdateRequest $dataUpdateRequest) {
                return view('club.data-update-request.datatables.club', compact('dataUpdateRequest'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|User $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Club $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('review_result', function (DataUpdateRequest $dataUpdateRequest) {
                return $dataUpdateRequest->show_result;
            })
            ->rawColumns(['club_id', 'review_result', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param  DataUpdateRequest  $model
     * @return Builder|\Illuminate\Database\Query\Builder|Collection
     */
    public function query(DataUpdateRequest $model)
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
            ->parameters($this->getBuilderParameters())
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
            'id'            => ['title' => '#'],
            'club_id'       => ['title' => '社團'],
            'reason'        => ['title' => '申請原因'],
            'submit_at'     => ['title' => '申請時間'],
            'review_result' => ['title' => '審核結果'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'dataupdaterequest_' . time();
    }
}
