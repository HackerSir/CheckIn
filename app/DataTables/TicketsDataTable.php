<?php

namespace App\DataTables;

use App\Models\Student;
use App\Models\Ticket;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class TicketsDataTable extends DataTable
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
            ->editColumn('student_nid', function (Ticket $ticket) {
                return view('ticket.datatables.student', compact('ticket'))->render();
            })
            ->filterColumn('student_nid', function ($query, $keyword) {
                /* @var Builder|Ticket $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->rawColumns(['student_nid']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Ticket $model
     * @return \Illuminate\Database\Eloquent\Builder|Builder|Collection
     */
    public function query(Ticket $model)
    {
        return $model->newQuery()->with('student')->select(array_keys($this->getColumns()));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id'          => ['title' => '抽獎編號'],
            'student_nid' => ['title' => '學生'],
            'created_at'  => ['title' => '取得時間'],
        ];
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
                'order'      => [[0, 'desc']],
                'pageLength' => 50,
            ]);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tickets_' . time();
    }
}
