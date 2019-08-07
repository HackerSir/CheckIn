<?php

namespace App\DataTables;

use App\Club;
use App\PaymentRecord;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class PaymentRecordDataTable extends DataTable
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
            ->addColumn('action', 'payment-record.datatables.action')
            ->editColumn('club_id', function (PaymentRecord $paymentRecord) {
                return view('payment-record.datatables.club', compact('paymentRecord'))->render();
            })
            ->editColumn('student', function (PaymentRecord $paymentRecord) {
                return $paymentRecord->student->display_name ?? null;
            })
            ->editColumn('is_paid', function (PaymentRecord $paymentRecord) {
                return $paymentRecord->is_paid ? 'O' : 'X';
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|PaymentRecord $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Club $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('user_id', function (PaymentRecord $paymentRecord) {
                return $paymentRecord->user->display_name ?? null;
            })
            ->filterColumn('user_id', function ($query, $keyword) {
                /* @var Builder|PaymentRecord $query */
                $query->whereHas('user', function ($query) use ($keyword) {
                    /* @var Builder|User $query */
                    $query->where('nid', 'like', '%' . $keyword . '%')
                        ->orWhere('name', 'like', '%' . $keyword . '%');
                });
            })
            ->rawColumns(['club_id', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param PaymentRecord $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PaymentRecord $model)
    {
        return $model->newQuery()->with('club', 'user.student');
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
            ->minifiedAjax()
            ->addAction(['title' => '操作'])
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'order'      => [[0, 'desc']],
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
            'id'         => ['title' => '#'],
            'club_id'    => ['title' => '社團'],
            'nid'        => ['title' => 'NID'],
            'name'       => ['title' => '姓名'],
            'student'    => ['title' => '對應學生'],
            'is_paid'    => ['title' => '已付清'],
            'handler'    => ['title' => '經手人'],
            'note'       => ['title' => '備註'],
            'user_id'    => ['title' => '操作者'],
            'updated_at' => ['title' => '更新時間'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PaymentRecord_' . date('YmdHis');
    }
}
