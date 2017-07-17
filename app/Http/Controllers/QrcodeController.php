<?php

namespace App\Http\Controllers;

use App\DataTables\QrcodesDataTable;
use App\Qrcode;
use App\QrcodeSet;
use App\Services\StudentService;
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
        $qrcodeSet = QrcodeSet::create();

        $amount = $request->get('amount');
        for ($i = 0; $i < $amount; $i++) {
            Qrcode::create(['qrcode_set_id' => $qrcodeSet->id]);
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
        return view('qrcode.show', compact('qrcode'));
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
     * @param StudentService $studentService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function bind(Request $request, StudentService $studentService)
    {
        $this->validate($request, [
            'nid'  => ['required', 'regex:#^[a-zA-Z]\d+$#'],
            'code' => 'required|exists:qrcodes,code',
        ]);

        $nid = trim(strtoupper($request->get('nid')));
        //若以掃描槍輸入，需去除最後一碼
        $nidLength = strlen($nid);
        if (strlen($nid) == 7 || strlen($nid) == 9) {
            $nid = substr($nid, 0, $nidLength - 1);
        }
        //找出學生（若本地沒有，會自動從API找）
        $student = $studentService->findByNid($nid);
        if (!$student) {
            return back()->withErrors(['nid' => '無法找到此學生'])->withInput();
        }

        //找出QRCode
        /** @var Qrcode $qrcode */
        $qrcode = Qrcode::where('code', $request->get('code'))->first();
        if ($qrcode->bind_at) {
            return back()->withErrors(['code' => '代碼無效（已使用過）'])->withInput();
        }

        //綁定
        $student->qrcode()->save($qrcode);

        return back()->with('global', '已綁定');
    }
}
