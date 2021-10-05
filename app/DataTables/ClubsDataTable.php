<?php

namespace App\DataTables;

use App\Models\Booth;
use App\Models\Club;
use App\Models\ClubType;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ClubsDataTable extends DataTable
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
            ->editColumn('club_type_id', function (Club $club) {
                return view('club.datatables.club-type', compact('club'))->render();
            })
            ->filterColumn('club_type_id', function ($query, $keyword) {
                /* @var Builder|Club $query */
                $query->whereHas('clubType', function ($query) use ($keyword) {
                    /* @var Builder|ClubType $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('name', function (Club $club) {
                return view('club.datatables.name', compact('club'))->render();
            })
            ->addColumn('booth', function (Club $club) {
                return view('club.datatables.booth', compact('club'))->render();
            })
            ->filterColumn('booth', function ($query, $keyword) {
                /* @var Builder|Club $query */
                $query->whereHas('booths', function ($query) use ($keyword) {
                    /* @var Builder|Booth $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('is_counted', 'club.datatables.is_counted')
            ->rawColumns(['club_type_id', 'name', 'booth', 'is_counted']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param  Club  $model
     * @return \Illuminate\Database\Eloquent\Builder|Builder|Collection
     */
    public function query(Club $model)
    {
        return $model->newQuery()->with('clubType', 'booths', 'imgurImage')->withCount('records', 'feedback');
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
            'id'             => ['title' => '#'],
            'club_type_id'   => ['title' => '類型'],
            'number'         => ['title' => '編號'],
            'name'           => ['title' => '名稱'],
            'booth'          => ['title' => '攤位'],
            'is_counted'     => [
                'orderable'  => false,
                'searchable' => false,
                'title'      => '集點',
            ],
            'records_count'  => [
                'searchable' => false,
                'title'      => '打卡',
            ],
            'feedback_count' => [
                'searchable' => false,
                'title'      => '回饋',
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
        return 'clubs_' . time();
    }
}
