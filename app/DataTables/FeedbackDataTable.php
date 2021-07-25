<?php

namespace App\DataTables;

use App\Models\Club;
use App\Models\Feedback;
use App\Models\Student;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class FeedbackDataTable extends DataTable
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
            ->addColumn('action', 'feedback.datatables.action')
            ->editColumn('student_nid', function (Feedback $feedback) {
                return view('feedback.datatables.student', compact('feedback'))->render();
            })
            ->filterColumn('student_nid', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('club_id', function (Feedback $feedback) {
                return view('feedback.datatables.club', compact('feedback'))->render();
            })
            ->filterColumn('club_id', function ($query, $keyword) {
                /* @var Builder|Feedback $query */
                $query->whereHas('club', function ($query) use ($keyword) {
                    /* @var Builder|Club $query */
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('contact_info', function (Feedback $feedback) {
                return view('feedback.datatables.contact_info', compact('feedback'))->render();
            })
            ->editColumn('custom_question_and_answer', function (Feedback $feedback) {
                if (!$feedback->custom_question) {
                    return null;
                }

                return view('feedback.datatables.custom_question_and_answer', compact('feedback'))->render();
            })
            ->editColumn('join_club_intention', function (Feedback $feedback) {
                return $feedback->join_club_intention_text;
            })
            ->editColumn('join_tea_party_intention', function (Feedback $feedback) {
                return $feedback->join_tea_party_intention_text;
            })
            ->rawColumns(['student_nid', 'club_id', 'contact_info', 'custom_question_and_answer', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param Feedback $model
     * @return \Illuminate\Database\Eloquent\Builder|Builder|Collection
     */
    public function query(Feedback $model)
    {
        return $model->newQuery()->with('student', 'club.clubType');
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
            'id'                         => ['title' => '#'],
            'student_nid'                => ['title' => '學生'],
            'club_id'                    => ['title' => '社團'],
            'contact_info'               => [
                'title'      => '聯絡資訊',
                'searchable' => false,
                'orderable'  => false,
            ],
            'phone'                      => [
                'title'   => '電話',
                'visible' => false,
            ],
            'email'                      => [
                'title'   => '信箱',
                'visible' => false,
            ],
            'facebook'                   => [
                'title'   => 'Facebook',
                'visible' => false,
            ],
            'line'                       => [
                'title'   => 'LINE',
                'visible' => false,
            ],
            'message'                    => [
                'title'      => '訊息',
                'searchable' => false,
                'orderable'  => false,
            ],
            'custom_question_and_answer' => [
                'title'      => '社團自訂問答',
                'searchable' => false,
                'orderable'  => false,
            ],
            'custom_question'            => [
                'title'   => '社團自訂問題',
                'visible' => false,
            ],
            'answer_of_custom_question'  => [
                'title'   => '對於社團自訂問題的回答',
                'visible' => false,
            ],
            'join_club_intention'        => [
                'title'      => '加入社團意願',
                'searchable' => false,
            ],
            'join_tea_party_intention'   => [
                'title'      => '參加迎新茶會意願',
                'searchable' => false,
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
        return 'feedback_' . time();
    }
}
