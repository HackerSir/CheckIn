<?php

namespace App\DataTables;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', 'user.datatables.action')
            ->editColumn('name', 'user.datatables.name')
            ->editColumn('email', 'user.datatables.email')
            ->editColumn('club_id', function ($booth) {
                return view('booth.datatables.club', compact('booth'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|User $query */
                $query->whereIn('club_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('clubs.id')
                        ->from('clubs')
                        ->join('users', 'clubs.id', '=', 'club_id')
                        ->whereRaw('clubs.name LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(User $model)
    {
        return $model->newQuery()->with('roles');
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
            ->ajax('')
            ->addAction(['title' => '操作'])
            ->parameters($this->getBuilderParameters())
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
            'id'      => ['title' => '#'],
            'name'    => ['title' => '使用者'],
            'email'   => ['title' => '信箱'],
            'club_id' => ['title' => '負責社團'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users_' . time();
    }
}
