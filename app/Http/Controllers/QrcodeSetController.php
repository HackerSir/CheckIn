<?php

namespace App\Http\Controllers;

use App\DataTables\QrcodesDataTable;
use App\DataTables\QrcodeSetsDataTable;
use App\DataTables\Scopes\QrcodeQrcodeSetScope;
use App\Qrcode;
use App\QrcodeSet;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('qrcode-set.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|integer|min:1',
        ]);
        $qrcodeSet = QrcodeSet::create();

        $amount = $request->get('amount');
        for ($i = 0; $i < $amount; $i++) {
            Qrcode::create(['qrcode_set_id' => $qrcodeSet->id]);
        }

        return redirect()->route('qrcode-set.show', $qrcodeSet->id)->with('global', "QR Code 已新增{$amount}組");
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

    /**
     * 下載 QR Code PDF
     *
     * @param QrcodeSet $qrcodeSet
     * @return \Illuminate\Http\Response
     */
    public function download(QrcodeSet $qrcodeSet)
    {
        //TODO
    }
}
