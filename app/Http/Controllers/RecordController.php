<?php

namespace App\Http\Controllers;

use App\DataTables\RecordsDataTable;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RecordsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(RecordsDataTable $dataTable)
    {
        return $dataTable->render('record.index');
    }
}
