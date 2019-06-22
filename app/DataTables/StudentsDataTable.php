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
            ->editColumn('nid', function (Student $student) {
                /** @var Student $student */
                return view('student.datatables.nid', compact('student'))->render();
            })
            ->editColumn('name', 'student.datatables.name')
            ->editColumn('class', function (Student $student) {
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
            ->editColumn('is_dummy', function (Student $student) {
                return $student->is_dummy ? 'O' : 'X';
            })
            ->rawColumns(['nid', 'name', 'class']);
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
            'nid'            => ['title' => 'NID'],
            'name'           => ['title' => '姓名'],
            'class'          => ['title' => '院系班級'],
            'in_year'        => ['title' => '入學年度'],
            'gender'         => ['title' => '性別'],
            'is_dummy'       => ['title' => '虛構資料'],
            'fetch_at'       => ['title' => '資料獲取時間'],
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
