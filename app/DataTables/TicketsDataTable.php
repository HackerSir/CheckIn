<?php

namespace App\DataTables;

use App\Ticket;
use Illuminate\Database\Query\Builder;
use Yajra\Datatables\Services\DataTable;

class TicketsDataTable extends DataTable
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
            ->editColumn('student_id', function ($ticket) {
                return view('ticket.datatables.student', compact('ticket'))->render();
            })
            ->filterColumn('student_id', function ($query, $keyword) {
                /* @var Builder|Ticket $query */
                $query->whereIn('student_id', function ($query) use ($keyword) {
                    /* @var Builder $query */
                    $query->select('students.id')
                        ->from('students')
                        ->join('tickets', 'students.id', '=', 'student_id')
                        ->whereRaw('students.name LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('students.nid LIKE ?', ['%' . $keyword . '%']);
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
        /** @var Ticket|\Illuminate\Database\Eloquent\Builder $query */
        $query = Ticket::with('student')->select(array_keys($this->getColumns()));

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
            'id'         => ['title' => '抽獎編號'],
            'student_id' => ['title' => '學生'],
            'created_at' => ['title' => '取得時間'],
        ];
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
