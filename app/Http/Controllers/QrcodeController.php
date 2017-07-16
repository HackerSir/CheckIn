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
        return view('qrcode.create');
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
        $amount = $request->get('amount');
        for ($i = 0; $i < $amount; $i++) {
            Qrcode::create();
        }

        return redirect()->route('qrcode.index')->with('global', "QR Code 已新增{$amount}組");
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

    /**
     * 綁定QRCode的表單
     *
     * @return \Illuminate\Http\Response
     */
    public function bindForm()
    {
        $qrcodes = Qrcode::with('student')
            ->whereNotNull('student_id')
            ->whereNotNull('bind_at')
            ->orderBy('bind_at', 'desc')->take(10)->get();

        return view('qrcode.bind', compact('qrcodes'));
    }

    /**
     * 綁定QRCode
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bind(Request $request)
    {
        $this->validate($request, [
            'nid'  => ['required', 'regex:#^[a-zA-Z]\d+$#'],
            'code' => 'required|exists:qrcodes,code',
        ]);

        //TODO: 找出學生

        //TODO: 找出QRCode

        //TODO: 綁定

        dd($request->all());
    }
}
