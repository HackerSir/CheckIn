<?php

namespace App\Http\Controllers;

use App\DataTables\QrcodesDataTable;
use App\Qrcode;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param QrcodesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(QrcodesDataTable $dataTable)
    {
        return $dataTable->render('qrcode.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Qrcode $qrcode
     * @return \Illuminate\Http\Response
     */
    public function show(Qrcode $qrcode)
    {
        //TODO
    }
}
