<?php

namespace App\DataTables;

use App\Presenters\ActivityLogPresenter;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ActivityLogDataTable extends DataTable
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
        $activityLogPresenter = app(ActivityLogPresenter::class);

        return $dataTable
            ->editColumn('action', 'activity-log.datatables.action')
            ->editColumn('subject_id', function (Activity $activity) use ($activityLogPresenter) {
                return $activityLogPresenter->getRouteLink($activity->subject_type, $activity->subject_id);
            })->editColumn('subject_type', function (Activity $activity) {
                return str_replace(['App\\', 'Models\\'], '', $activity->subject_type);
            })->editColumn('causer_id', function (Activity $activity) use ($activityLogPresenter) {
                return $activityLogPresenter->getRouteLink($activity->causer_type, $activity->causer_id);
            })->editColumn('causer_type', function (Activity $activity) {
                return str_replace(['App\\', 'Models\\'], '', $activity->causer_type);
            })
            ->rawColumns(['subject_id', 'causer_id', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Activity $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Activity $model)
    {
        return $model->newQuery()->select(
            'id',
            'log_name',
            'description',
            'subject_id',
            'subject_type',
            'causer_id',
            'causer_type',
            'created_at'
        );
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
            'id' => ['title' => '#'],
            'log_name',
            'description',
            'subject_id',
            'subject_type',
            'causer_id',
            'causer_type',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ActivityLog_' . date('YmdHis');
    }
}
