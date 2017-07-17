<?php

namespace App\Http\Controllers;

use App\DataTables\QrcodeSetsDataTable;
use App\QrcodeSet;

class QrcodeSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param QrcodeSetsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(QrcodeSetsDataTable $dataTable)
    {
        return $dataTable->render('qrcode-set.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QrcodeSet $qrcodeSet
     * @return \Illuminate\Http\Response
     */
    public function show(QrcodeSet $qrcodeSet)
    {
        //TODO
        $qrcodeSet->load('qrcodes');
        dd($qrcodeSet->toArray());
    }
}
