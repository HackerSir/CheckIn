<?php

namespace App\Http\Controllers;

use App\DataTables\QrcodesDataTable;
use App\DataTables\QrcodeSetsDataTable;
use App\DataTables\Scopes\QrcodeQrcodeSetScope;
use App\Models\Qrcode;
use App\Models\QrcodeSet;
use App\Services\FileService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;

class QrcodeSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  QrcodeSetsDataTable  $dataTable
     * @return JsonResponse|Response|View
     */
    public function index(QrcodeSetsDataTable $dataTable)
    {
        return $dataTable->render('qrcode-set.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('qrcode-set.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|integer|min:1',
        ]);
        $qrcodeSet = QrcodeSet::create();

        $amount = $request->get('amount');
        for ($i = 0; $i < $amount; $i++) {
            Qrcode::create([
                'qrcode_set_id'  => $qrcodeSet->id,
                'auto_generated' => false,
            ]);
        }

        return redirect()->route('qrcode-set.show', $qrcodeSet->id)->with('success', "QR Code 已新增{$amount}組");
    }

    /**
     * Display the specified resource.
     *
     * @param  QrcodeSet  $qrcodeSet
     * @param  QrcodesDataTable  $qrcodesDataTable
     * @return JsonResponse|Response|View
     */
    public function show(QrcodeSet $qrcodeSet, QrcodesDataTable $qrcodesDataTable)
    {
        $qrcodesDataTable->addScope(new QrcodeQrcodeSetScope($qrcodeSet->id));

        return $qrcodesDataTable->render('qrcode-set.show', compact('qrcodeSet'));
    }

    /**
     * 下載 QR Code Word
     *
     * @param  QrcodeSet  $qrcodeSet
     * @param  FileService  $fileService
     * @return Response
     *
     * @throws Exception
     */
    public function download(QrcodeSet $qrcodeSet, FileService $fileService)
    {
        //檔名
        $fileName = 'QRCodeSet_' . $qrcodeSet->id . '.docx';
        //建立檔案
        $phpWord = $fileService->generateQRCodeDocFile($qrcodeSet);
        //輸出檔案
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        //設定路徑（PHP暫存路徑）
        $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'word_' . Carbon::now()->getTimestamp() . '.docx';
        //建立暫存檔案
        $objWriter->save($filePath);

        //下載檔案
        return response()->download($filePath, $fileName);
    }
}
