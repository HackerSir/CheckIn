<?php

namespace App\DataTables;

use App\Club;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ClubsDataTable extends DataTable
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
            ->addColumn('action', 'club.datatables.action')
            ->editColumn('club_type_id', function ($club) {
                return view('club.datatables.club-type', compact('club'))->render();
            })
            ->filterColumn('club_type_id', function ($query, $keyword) {
                /* @var Builder|Club $query */
                $query->whereIn('club_type_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('club_types.id')
                        ->from('club_types')
                        ->join('clubs', 'club_types.id', '=', 'club_type_id')
                        ->whereRaw('club_types.name LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->editColumn('name', function ($club) {
                return view('club.datatables.name', compact('club'))->render();
            })
            ->addColumn('booth', function ($club) {
                return view('club.datatables.booth', compact('club'))->render();
            })
            ->filterColumn('booth', function ($query, $keyword) {
                /* @var Builder|Club $query */
                $query->whereIn('id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('club_id')
                        ->from('booths')
                        ->join('clubs', 'clubs.id', '=', 'booths.club_id')
                        ->whereRaw('booths.name LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->editColumn('is_counted', 'club.datatables.is_counted')
            ->escapeColumns([]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Club $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
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
