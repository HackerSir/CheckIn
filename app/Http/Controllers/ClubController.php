<?php

namespace App\Http\Controllers;

use App\Club;
use App\ClubType;
use App\DataTables\ClubsDataTable;
use App\Services\FcuApiService;
use App\Services\FileService;
use App\Services\ImgurImageService;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\RichText;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ClubsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(ClubsDataTable $dataTable)
    {
        return $dataTable->render('club.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('club.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ImgurImageService $imgurImageService
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImgurImageService $imgurImageService)
    {
        $this->validate($request, [
            'number'       => 'nullable',
            'name'         => 'required',
            'club_type_id' => 'nullable|exists:club_types,id',
            'description'  => 'nullable|max:300',
            'url'          => 'nullable|url',
            'image_file'   => 'image',
        ]);

        $club = Club::create($request->all());

        //上傳圖片
        $uploadedFile = $request->file('image_file');
        if ($uploadedFile) {
            $imgurImage = $imgurImageService->upload($uploadedFile);
            $club->imgurImage()->save($imgurImage);
        }

        //更新攤位負責人
        $attachUserIds = (array) $request->get('user_id');
        $attachUsers = User::whereDoesntHave('club')->whereIn('id', $attachUserIds)->get();
        $club->users()->saveMany($attachUsers);

        return redirect()->route('club.show', $club)->with('global', '社團已新增');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        return view('club.show', compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        return view('club.create-or-edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Club $club
     * @param ImgurImageService $imgurImageService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, ImgurImageService $imgurImageService)
    {
        $this->validate($request, [
            'number'       => 'nullable',
            'name'         => 'required',
            'club_type_id' => 'nullable|exists:club_types,id',
            'description'  => 'nullable|max:300',
            'url'          => 'nullable|url',
            'image_file'   => 'image',
        ]);

        $club->update($request->all());

        //上傳圖片
        $uploadedFile = $request->file('image_file');
        if ($uploadedFile) {
            //刪除舊圖
            if ($club->imgurImage) {
                $club->imgurImage->delete();
            }
            //上傳新圖
            $imgurImage = $imgurImageService->upload($uploadedFile);
            $club->imgurImage()->save($imgurImage);
        }

        //更新攤位負責人
        $oldUserIds = (array) $club->users->pluck('id')->toArray();
        $newUserIds = (array) $request->get('user_id');
        $detachUserIds = array_diff($oldUserIds, $newUserIds);
        $attachUserIds = array_diff($newUserIds, $oldUserIds);

        /** @var User[] $detachUsers */
        $detachUsers = User::whereIn('id', $detachUserIds)->get();
        foreach ($detachUsers as $detachUser) {
            $detachUser->club()->dissociate();
            $detachUser->save();
        }
        $attachUsers = User::whereDoesntHave('club')->whereIn('id', $attachUserIds)->get();
        $club->users()->saveMany($attachUsers);

        return redirect()->route('club.show', $club)->with('global', '社團已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return redirect()->route('club.index')->with('global', '社團已刪除');
    }

    public function getImport()
    {
        return view('club.import');
    }

    public function postImport(Request $request, FileService $fileService, FcuApiService $fcuApiService)
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
        $invalidNidCount = 0;
        foreach ($spreadsheet->getAllSheets() as $sheetId => $sheet) {
            foreach ($sheet->getRowIterator() as $rowNumber => $row) {
                //忽略第一列
                if ($rowNumber == 1) {
                    continue;
                }
                //該列資料
                $rowData = [];
                for ($col = 0; $col < 8; $col++) {
                    $cell = $sheet->getCellByColumnAndRow($col, $row->getRowIndex());
                    $colData = $cell->getValue();
                    if (!($colData instanceof RichText)) {
                        $colData = trim($cell->getFormattedValue());
                    }
                    $rowData[] = $colData;
                }
                //資料
                $name = $rowData[0];
                $number = $rowData[1];
                $clubTypeName = $rowData[2];
                $ownerNIDs = [];
                for ($i = 0; $i < 5; $i++) {
                    $ownerNIDs[$i] = strtoupper($rowData[$i + 3]);
                }

                //資料必須齊全
                if (empty($name)) {
                    $skipCount++;
                    continue;
                }
                //社團類型
                if (!empty($clubTypeName)) {
                    /** @var ClubType $clubType */
                    $clubType = ClubType::query()->firstOrCreate([
                        'name' => $clubTypeName,
                    ], [
                        'color'      => '#000000',
                        'is_counted' => true,
                    ]);
                }

                //建立社團
                $club = Club::query()->updateOrCreate([
                    'name'         => $name,
                    'number'       => $number,
                    'club_type_id' => isset($clubType) ? $clubType->id : null,
                ]);

                //攤位負責人
                $ownerNIDs = array_filter($ownerNIDs);
                foreach ($ownerNIDs as $ownerNID) {
                    //試著找出學生
                    /** @var Student $student */
                    $student = Student::whereNid($ownerNID)->first();
                    if (!$student) {
                        //若不存在，嘗試從API抓取
                        //取得學生資料
                        $stuInfo = $fcuApiService->getStuInfo($ownerNID);
                        if (is_array($stuInfo) && isset($stuInfo['status']) && $stuInfo['status'] == 1) {
                            //有學生資料
                            $student = Student::query()->updateOrCreate([
                                'nid' => $stuInfo['stu_id'],
                            ], [
                                'name'      => $stuInfo['stu_name'],
                                'class'     => $stuInfo['stu_class'],
                                'unit_name' => $stuInfo['unit_name'],
                                'dept_name' => $stuInfo['dept_name'],
                                'in_year'   => $stuInfo['in_year'],
                                'gender'    => $stuInfo['stu_sex'],
                            ]);
                        }
                    }
                    if (!$student) {
                        //NID無效
                        $invalidNidCount++;
                        continue;
                    }
                    //找出使用者
                    $user = $student->user;
                    if (!$user) {
                        $email = $ownerNID . '@fcu.edu.tw';
                        $user = User::query()->updateOrCreate([
                            'email' => $email,
                        ], [
                            'name'        => $student->name,
                            'email'       => $email,
                            'password'    => '',
                            'confirm_at'  => Carbon::now(),
                            'register_at' => Carbon::now(),
                            'register_ip' => \Request::getClientIp(),
                        ]);
                    }
                    //設定為負責人
                    $user->club()->associate($club);
                    $user->save();
                }

                $successCount++;
            }
        }

        return redirect()->route('club.index')
            ->with('global', "匯入完成(成功:{$successCount}/跳過:{$skipCount}/NID無效:{$invalidNidCount})");
    }

    public function downloadImportSample()
    {
        $path = resource_path('sample/club_import_sample.xlsx');

        return response()->download($path);
    }
}
