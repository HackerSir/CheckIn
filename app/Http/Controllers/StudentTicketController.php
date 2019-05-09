<?php

namespace App\Http\Controllers;

use App\DataTables\StudentTicketsDataTable;
use App\Services\FileService;
use App\Services\StudentService;
use App\StudentTicket;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class StudentTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StudentTicketsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(StudentTicketsDataTable $dataTable)
    {
        return $dataTable->render('student-ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student-ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param StudentService $studentService
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, StudentService $studentService)
    {
        $this->validate($request, [
            'id'  => 'nullable|integer|min:1|unique:student_tickets,id',
            'nid' => [
                'required',
                'regex:#^[a-zA-Z]\d+$#',
            ],
        ]);

        $student = $studentService->findByNid($request->get('nid'));
        if (!$student) {
            return back()->withErrors(['nid' => '查無此人'])->withInput();
        }
        if ($student->studentTicket) {
            return back()->withErrors(['nid' => '學號 已經存在。'])->withInput();
        }

        StudentTicket::create(array_merge($request->only('id'), [
            'student_nid' => $student->nid,
        ]));

        return redirect()->route('student-ticket.index')->with('success', '學生抽獎編號已新增');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\StudentTicket $studentTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentTicket $studentTicket)
    {
        return view('student-ticket.edit', compact('studentTicket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\StudentTicket $studentTicket
     * @param StudentService $studentService
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, StudentTicket $studentTicket, StudentService $studentService)
    {
        $this->validate($request, [
            'nid' => [
                'required',
                'regex:#^[a-zA-Z]\d+$#',
            ],
        ]);

        $student = $studentService->findByNid($request->get('nid'));
        if (!$student) {
            return back()->withErrors(['nid' => '查無此人'])->withInput();
        }
        if ($student->studentTicket && $student->studentTicket->id != $studentTicket->id) {
            return back()->withErrors(['nid' => '學號 已經存在。'])->withInput();
        }

        $studentTicket->update(array_merge($request->only('name', 'class'), [
            'student_nid' => $student->nid,
        ]));

        return redirect()->route('student-ticket.index')->with('success', '學生抽獎編號已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\StudentTicket $studentTicket
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(StudentTicket $studentTicket)
    {
        $studentTicket->delete();

        return redirect()->route('student-ticket.index')->with('success', '學生抽獎編號已刪除');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroyAll()
    {
        StudentTicket::query()->delete();

        return redirect()->route('student-ticket.index')->with('success', '學生抽獎編號已全數刪除');
    }

    public function ticket()
    {
        return view('student-ticket.ticket');
    }

    public function ticketInfo(Request $request)
    {
        $id = $request->get('id');
        $ticket = StudentTicket::find($id);
        if (!$ticket) {
            $json = [
                'found' => false,
                'id'    => sprintf('%04d', $id),
            ];

            return response()->json($json);
        }
        $json = [
            'found' => true,
            'id'    => sprintf('%04d', $ticket->id),
            'name'  => $ticket->student->name,
            'class' => $ticket->student->class,
        ];

        return response()->json($json);
    }

    public function getImport()
    {
        return view('student-ticket.import');
    }

    /**
     * @param Request $request
     * @param FileService $fileService
     * @param StudentService $studentService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postImport(Request $request, FileService $fileService, StudentService $studentService)
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
                for ($col = 1; $col <= 4; $col++) {
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
                //NID必須填寫
                if (empty($nid)) {
                    $skipCount++;
                    continue;
                }
                //找出學生
                $student = $studentService->findByNid($nid);
                if (!$student) {
                    $skipCount++;
                    continue;
                }
                //建立資料
                try {
                    //刪除相同ID或NID的紀錄
                    StudentTicket::query()->where('id', $id)->orWhere('student_nid', $student->nid)->delete();
                    //新增紀錄
                    StudentTicket::query()->create([
                        'id'          => $id,
                        'student_nid' => $student->nid,
                    ]);
                } catch (\Exception $exception) {
                    $skipCount++;
                    continue;
                }

                $successCount++;
            }
        }

        return redirect()->route('student-ticket.index')->with('success', "匯入完成(成功:{$successCount}/跳過:{$skipCount})");
    }

    public function downloadImportSample()
    {
        $path = resource_path('sample/student_ticket_import_sample.xlsx');

        return response()->download($path);
    }
}
