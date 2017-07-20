<?php

namespace App\Http\Controllers;

use App\DataTables\QrcodesDataTable;
use App\DataTables\QrcodeSetsDataTable;
use App\DataTables\Scopes\QrcodeQrcodeSetScope;
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
     * @param QrcodesDataTable $qrcodesDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(QrcodeSet $qrcodeSet, QrcodesDataTable $qrcodesDataTable)
    {
        $qrcodesDataTable->addScope(new QrcodeQrcodeSetScope($qrcodeSet->id));

        return $qrcodesDataTable->render('qrcode-set.show', compact('qrcodeSet'));
    }
}
