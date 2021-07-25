<?php

namespace App\DataTables;

use App\Models\ContactInformation;
use App\Models\Student;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ContactInformationDataTable extends DataTable
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
            ->addColumn('action', 'contact-information.datatables.action')
            ->editColumn('student_nid', function (ContactInformation $contactInformation) {
                return $contactInformation->student->display_name;
            })
            ->filterColumn('student_nid', function ($query, $keyword) {
                /* @var Builder|ContactInformation $query */
                $query->whereHas('student', function ($query) use ($keyword) {
                    /* @var Builder|Student $query */
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('nid', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('is_freshman', function (ContactInformation $contactInformation) {
                /** @var ContactInformation $contactInformation */
                return view('contact-information.datatables.is_freshman', compact('contactInformation'))->render();
            })
            ->rawColumns(['is_freshman', 'action']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @param ContactInformation $model
     * @return \Illuminate\Database\Eloquent\Builder|Builder|Collection
     */
    public function query(ContactInformation $model)
    {
        return $model->newQuery()->with('student');
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
            'student_nid' => ['title' => '學生'],
            'is_freshman' => [
                'searchable' => false,
                'orderable'  => false,
                'title'      => '新生',
            ],
            'phone'       => ['title' => '電話'],
            'email'       => ['title' => '信箱'],
            'facebook'    => ['title' => 'Facebook'],
            'line'        => ['title' => 'LINE'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'contactInformation_' . time();
    }
}
