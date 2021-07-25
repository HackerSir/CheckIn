<?php

namespace App\Http\Controllers;

use App\DataTables\QrcodesDataTable;
use App\Models\Qrcode;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param QrcodesDataTable $dataTable
     * @return JsonResponse|Response|View
     */
    public function index(QrcodesDataTable $dataTable)
    {
        return $dataTable->render('qrcode.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Qrcode $qrcode
     * @return Response
     */
    public function show(Qrcode $qrcode)
    {
        return view('qrcode.show', compact('qrcode'));
    }

    /**
     * 綁定QRCode的表單
     *
     * @return Response
     */
    public function bindForm()
    {
        $qrcodes = Qrcode::with('student')
            ->whereNotNull('student_nid')
            ->whereNotNull('bind_at')
            ->orderBy('bind_at', 'desc')->take(10)->get();

        return view('qrcode.bind', compact('qrcodes'));
    }

    /**
     * 綁定QRCode
     *
     * @param Request $request
     * @param StudentService $studentService
     * @return RedirectResponse|Response
     * @throws ValidationException
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

        return back()->with('success', '已綁定');
    }
}
