<?php

namespace App\DataTables;

use App\Models\Qrcode;
use App\Models\Student;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class QrcodesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->editColumn('code', function (Qrcode $qrcode) {
                return view('qrcode.datatables.code', compact('qrcode'))->render();
            })
            ->editColumn('student_nid', function (Qrcode $qrcode) {
                return view('qrcode.datatables.student', compact('qrcode'))->render();
            })
            ->filterColumn('student_nid', function ($query, $keyword) {
                /* @var Builder|Qrcode $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('auto_generated', function (Qrcode $qrcode) {
                return $qrcode->auto_generated ? 'O' : 'X';
            })
            ->editColumn('is_last_one', function (Qrcode $qrcode) {
                return view('qrcode.datatables.is_last_one', compact('qrcode'))->render();
            })
            ->rawColumns(['code', 'is_last_one']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Qrcode $model
     * @return \Illuminate\Database\Eloquent\Builder|Builder|Collection
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
            'id'             => ['title' => '#'],
            'code'           => ['title' => '代碼'],
            'student_nid'    => ['title' => '學生'],
            'bind_at'        => ['title' => '綁定時間'],
            'auto_generated' => [
                'title'      => '自動建立',
                'searchable' => false,
            ],
            'is_last_one'    => [
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
