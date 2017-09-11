<?php

namespace App\DataTables;

use App\Qrcode;
use Illuminate\Database\Query\Builder;
use Yajra\Datatables\Services\DataTable;

class QrcodesDataTable extends DataTable
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
            ->addColumn('action', 'qrcode.datatables.action')
            ->editColumn('code', function ($qrcode) {
                return view('qrcode.datatables.code', compact('qrcode'))->render();
            })
            ->editColumn('student_id', function ($qrcode) {
                return view('qrcode.datatables.student', compact('qrcode'))->render();
            })
            ->filterColumn('student_id', function ($query, $keyword) {
                /* @var Builder|Qrcode $query */
                $query->whereIn('student_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('students.id')
                        ->from('students')
                        ->join('qrcodes', 'students.id', '=', 'student_id')
                        ->whereRaw('students.name LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('students.nid LIKE ?', ['%' . $keyword . '%']);
                });
            })
            ->editColumn('is_last_one', function ($qrcode) {
                return view('qrcode.datatables.is_last_one', compact('qrcode'))->render();
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
        $query = Qrcode::with('student.qrcode');

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
