<?php

namespace App\DataTables;

use App\Student;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class StudentsDataTable extends DataTable
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
            ->addColumn('action', 'student.datatables.action')
            ->editColumn('class', function ($student) {
                return view('student.datatables.class', compact('student'))->render();
            })
            ->filterColumn('class', function ($query, $keyword) {
                /* @var Builder|Student $query */
                $query->where(function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('class', 'like', '%' . $keyword . '%')
                        ->orWhere('unit_name', 'like', '%' . $keyword . '%')
                        ->orWhere('dept_name', 'like', '%' . $keyword . '%');
                });
            })
            ->escapeColumns([]);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Student $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(Student $model)
    {
        return $model->newQuery()->withCount('records', 'feedback');
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
            'nid'            => ['title' => 'NID'],
            'name'           => ['title' => '姓名'],
            'class'          => ['title' => '院系班級'],
            'in_year'        => ['title' => '入學年度'],
            'gender'         => ['title' => '性別'],
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
        return 'students_' . time();
    }
}
