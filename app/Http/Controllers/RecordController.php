<?php

namespace App\Http\Controllers;

use App\DataTables\RecordsDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RecordsDataTable $dataTable
     * @return JsonResponse|Response|View
     */
    public function index(RecordsDataTable $dataTable)
    {
        return $dataTable->render('record.index');
    }
}
