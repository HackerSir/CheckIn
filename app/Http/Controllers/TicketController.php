<?php

namespace App\Http\Controllers;

use App\DataTables\TicketsDataTable;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TicketsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(TicketsDataTable $dataTable)
    {
        return $dataTable->render('ticket.index');
    }
}
