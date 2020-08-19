<?php

namespace App\Http\Controllers;

use App\Booth;
use App\DataTables\BoothsDataTable;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class BoothController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BoothsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(BoothsDataTable $dataTable)
    {
        return $dataTable->render('booth.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('booth.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'zone'      => 'nullable',
            'club_id'   => 'nullable|exists:clubs,id',
            'name'      => 'required|unique:booths',
            'longitude' => 'nullable|required_with:latitude|numeric|min:-180|max:180',
            'latitude'  => 'nullable|required_with:longitude|numeric|min:-90|max:90',
        ]);

        $booth = Booth::create($request->all());

        return redirect()->route('booth.show', $booth)->with('success', '攤位已新增');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Booth $booth
     * @return \Illuminate\Http\Response
     */
    public function show(Booth $booth)
    {
        return view('booth.show', compact('booth'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Booth $booth
     * @return \Illuminate\Http\Response
     */
    public function edit(Booth $booth)
    {
        return view('booth.edit', compact('booth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Booth $booth
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Booth $booth)
    {
        $this->validate($request, [
            'zone'      => 'nullable',
            'club_id'   => 'nullable|exists:clubs,id',
            'name'      => ['required', Rule::unique('booths')->ignore($booth->id)],
            'longitude' => 'nullable|required_with:latitude|numeric|min:-180|max:180',
            'latitude'  => 'nullable|required_with:longitude|numeric|min:-90|max:90',
        ]);

        $booth->update($request->all());

        return redirect()->route('booth.show', $booth)->with('success', '攤位已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Booth $booth
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Booth $booth)
    {
        $booth->delete();

        return redirect()->route('booth.index')->with('success', '攤位已刪除');
    }

    public function getImport()
    {
        return view('booth.import');
    }

    /**
     * @param Request $request
     * @param FileService $fileService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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
                for ($col = 1; $col <= 4; $col++) {
                    $cell = $sheet->getCellByColumnAndRow($col, $row->getRowIndex());
                    $colData = $cell->getValue();
                    if (!($colData instanceof RichText)) {
                        $colData = trim($cell->getFormattedValue());
                    }
                    $rowData[] = $colData;
                }
                //資料
                $zone = $rowData[0] ?: null;
                $name = $rowData[1];
                $latitude = filter_var($rowData[2], FILTER_VALIDATE_FLOAT);
                if ($latitude < -90 || $latitude > 90) {
                    $latitude = null;
                }
                $longitude = filter_var($rowData[3], FILTER_VALIDATE_FLOAT);
                if ($longitude < -180 || $longitude > 180) {
                    $longitude = null;
                }
                //資料必須齊全
                if (empty($name) || empty($latitude) || empty($longitude)) {
                    $skipCount++;
                    continue;
                }
                //建立資料
                Booth::updateOrCreate([
                    'name' => $name,
                ], [
                    'zone'      => $zone,
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                ]);

                $successCount++;
            }
        }

        return redirect()->route('booth.index')->with('success', "匯入完成(成功:{$successCount}/跳過:{$skipCount})");
    }

    public function downloadImportSample()
    {
        $path = resource_path('sample/booth_import_sample.xlsx');

        return response()->download($path);
    }
}
