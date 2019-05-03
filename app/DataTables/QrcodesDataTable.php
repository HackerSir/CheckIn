<?php

namespace App\DataTables;

use App\Qrcode;
use App\Student;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class QrcodesDataTable extends DataTable
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
            ->editColumn('code', function ($qrcode) {
                return view('qrcode.datatables.code', compact('qrcode'))->render();
            })
            ->editColumn('student_id', function ($qrcode) {
                return view('qrcode.datatables.student', compact('qrcode'))->render();
            })
            ->filterColumn('student_id', function ($query, $keyword) {
                /* @var Builder|Qrcode $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('is_last_one', function ($qrcode) {
                return view('qrcode.datatables.is_last_one', compact('qrcode'))->render();
            })
            ->rawColumns(['code', 'is_last_one']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Qrcode $model
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query(Qrcode $model)
    {
        return $model->newQuery()->with('student.qrcode');
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
            'id'          => ['title' => '#'],
            'code'        => ['title' => '代碼'],
            'student_id'  => ['title' => '學生'],
            'bind_at'     => ['title' => '綁定時間'],
            'is_last_one' => [
                'searchable' => false,
                'orderable'  => false,
                'title'      => '最後一組',
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
        return 'qrcodes_' . time();
    }
}
