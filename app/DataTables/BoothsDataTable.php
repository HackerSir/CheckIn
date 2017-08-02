<?php

namespace App\DataTables;

use App\Booth;
use Illuminate\Database\Query\Builder;
use Yajra\Datatables\Services\DataTable;

class BoothsDataTable extends DataTable
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
            ->addColumn('action', 'booth.datatables.action')
            ->editColumn('club_id', function ($booth) {
                return view('booth.datatables.club', compact('booth'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Booth $query */
                $query->whereIn('club_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('clubs.id')
                        ->from('clubs')
                        ->join('booths', 'clubs.id', '=', 'club_id')
                        ->whereRaw('clubs.name LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        /** @var Booth|\Illuminate\Database\Eloquent\Builder $query */
        $query = Booth::with('club')->select(array_keys($this->getColumns()));

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
            'id'        => ['title' => '#'],
            'name'      => ['title' => '名稱'],
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
