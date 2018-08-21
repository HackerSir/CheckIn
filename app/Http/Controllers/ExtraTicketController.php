<?php

namespace App\Http\Controllers;

use App\DataTables\ExtraTicketsDataTable;
use App\ExtraTicket;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class ExtraTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ExtraTicketsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(ExtraTicketsDataTable $dataTable)
    {
        return $dataTable->render('extra-ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('extra-ticket.create');
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
            'id'    => 'nullable|integer|min:1|unique:extra_tickets,id',
            'nid'   => 'required|unique:extra_tickets,nid',
            'name'  => 'required',
            'class' => 'required',
        ]);

        ExtraTicket::create(array_merge($request->all(), [
            'nid' => strtoupper($request->get('nid')),
        ]));

        return redirect()->route('extra-ticket.index')->with('success', '工作人員抽獎編號已新增');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtraTicket $extraTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraTicket $extraTicket)
    {
        return view('extra-ticket.edit', compact('extraTicket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ExtraTicket $extraTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraTicket $extraTicket)
    {
        $this->validate($request, [
            'nid'   => ['required', Rule::unique('extra_tickets', 'nid')->ignore($extraTicket->id)],
            'name'  => 'required',
            'class' => 'required',
        ]);

        $extraTicket->update(array_merge($request->only('name', 'class'), [
            'nid' => strtoupper($request->get('nid')),
        ]));

        return redirect()->route('extra-ticket.index')->with('success', '工作人員抽獎編號已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtraTicket $extraTicket
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ExtraTicket $extraTicket)
    {
        $extraTicket->delete();

        return redirect()->route('extra-ticket.index')->with('success', '工作人員抽獎編號已刪除');
    }

    public function destroyAll()
    {
        ExtraTicket::query()->delete();

        return redirect()->route('extra-ticket.index')->with('success', '工作人員抽獎編號已全數刪除');
    }

    public function ticket()
    {
        return view('extra-ticket.ticket');
    }

    public function ticketInfo(Request $request)
    {
        $id = $request->get('id');
        $extraTicket = ExtraTicket::find($id);
        if (!$extraTicket) {
            $json = [
                'found' => false,
                'id'    => sprintf('%04d', $id),
            ];

            return response()->json($json);
        }
        $json = [
            'found' => true,
            'id'    => sprintf('%04d', $extraTicket->id),
            'name'  => $extraTicket->name,
            'class' => $extraTicket->class,
        ];

        return response()->json($json);
    }

    public function getImport()
    {
        return view('extra-ticket.import');
    }

    public function postImport(Request $request, FileService $fileService)
    {
        //檢查匯入檔案格式為xls或xlsx
        $this->validate($request, [
            'import_file' => 'required|mimes:xls,xlsx',
        ]);

        $uploadedFile = $request->file('import_file');
        $uploadedFilePath = $uploadedFile->getPathname();
        $spreadsheet = $fileService->loadSpreadsheet($uploadedFilePath);
        if (!$spreadsheet) {
            return redirect()->back()->withErrors(['importFile' => '檔案格式限xls或xlsx']);
        }
        $successCount = 0;
        $skipCount = 0;
        foreach ($spreadsheet->getAllSheets() as $sheetId => $sheet) {
            foreach ($sheet->getRowIterator() as $rowNumber => $row) {
                //忽略第一列
                if ($rowNumber == 1) {
                    continue;
                }
                //該列資料
                $rowData = [];
                for ($col = 0; $col < 4; $col++) {
                    $cell = $sheet->getCellByColumnAndRow($col, $row->getRowIndex());
                    $colData = $cell->getValue();
                    if (!($colData instanceof RichText)) {
                        $colData = trim($cell->getFormattedValue());
                    }
                    $rowData[] = $colData;
                }
                //資料
                $id = $rowData[0];
                //ID僅接受正整數
                if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                    $id = null;
                }
                $nid = strtoupper($rowData[1]);
                $name = $rowData[2];
                $class = $rowData[3];
                //資料必須齊全
                if (empty($nid) || empty($name) || empty($class)) {
                    $skipCount++;
                    continue;
                }
                //建立資料
                try {
                    //刪除相同ID或NID的紀錄
                    ExtraTicket::query()->where('id', $id)->orWhere('nid', $nid)->delete();
                    //新增紀錄
                    ExtraTicket::query()->create([
                        'id'    => $id,
                        'nid'   => $nid,
                        'name'  => $name,
                        'class' => $class,
                    ]);
                } catch (\Exception $exception) {
                    $skipCount++;
                    continue;
                }

                $successCount++;
            }
        }

        return redirect()->route('extra-ticket.index')->with('success', "匯入完成(成功:{$successCount}/跳過:{$skipCount})");
    }

    public function downloadImportSample()
    {
        $path = resource_path('sample/extra_ticket_import_sample.xlsx');

        return response()->download($path);
    }
}
