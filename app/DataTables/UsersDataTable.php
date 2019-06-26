<?php

namespace App\DataTables;

use App\Club;
use App\Student;
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
            ->editColumn('name', 'user.datatables.name')
            ->editColumn('email', 'user.datatables.email')
            ->editColumn('club_id', function (User $user) {
                if (!$user->student) {
                    return null;
                }
                /** @var Club $club */
                $club = $user->student->clubs->first();

                return $club ? $club->display_name : null;
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|User $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->whereHas('clubs', function ($query) use ($keyword) {
                        /* @var Builder|Club $query */
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                });
            })
            ->rawColumns(['name', 'club_id', 'email']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(User $model)
    {
        return $model->newQuery()->with('roles', 'student.clubs.clubType');
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
            ->minifiedAjax(' ')
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
            'nid'     => [
                'title'   => 'NID',
                'visible' => false,
            ],
            'email'   => ['title' => '信箱 or NID'],
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
