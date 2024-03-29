<?php

namespace App\Http\Controllers;

use App\DataTables\ClubsDataTable;
use App\Models\Booth;
use App\Models\Club;
use App\Models\ClubType;
use App\Models\Student;
use App\Models\User;
use App\Services\FileService;
use App\Services\HTMLService;
use App\Services\ImgurImageService;
use App\Services\StudentService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  ClubsDataTable  $dataTable
     * @return JsonResponse|Response|View
     */
    public function index(ClubsDataTable $dataTable)
    {
        return $dataTable->render('club.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('club.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  ImgurImageService  $imgurImageService
     * @param  HTMLService  $HTMLService
     * @return Response
     *
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request, ImgurImageService $imgurImageService, HTMLService $HTMLService)
    {
        $this->validate($request, [
            'number'          => 'nullable',
            'name'            => 'required',
            'club_type_id'    => 'nullable|exists:club_types,id',
            'description'     => 'nullable|strip_max:600',
            'extra_info'      => 'nullable|strip_max:600',
            'url'             => 'nullable|url',
            'image_file'      => 'image',
            'custom_question' => 'nullable|max:255',
        ]);

        $club = Club::create(array_merge($request->all(), [
            'number'      => strtoupper($request->get('number')),
            'description' => $HTMLService->clean($request->get('description')),
            'extra_info'  => $HTMLService->clean($request->get('extra_info')),
        ]));

        //上傳圖片
        $uploadedFile = $request->file('image_file');
        if ($uploadedFile) {
            $imgurImage = $imgurImageService->upload($uploadedFile);
            $club->imgurImage()->save($imgurImage);
        }

        //更新攤位
        $attachBoothIds = (array) $request->get('booth_id');
        $attachBooths = Booth::whereDoesntHave('club')->whereIn('id', $attachBoothIds)->get();
        $club->booths()->saveMany($attachBooths);

        //更新工作人員＆社長
        $staffNids = (array) $request->get('staff_nid');
        $leaderNid = $request->get('leader_nid');
        $this->updateStaff($club, $leaderNid, $staffNids);

        return redirect()->route('clubs.show', $club)->with('success', '社團已新增');
    }

    /**
     * @param  Club  $club
     * @param  string  $leaderNid
     * @param  array  $staffNids
     */
    private function updateStaff(Club $club, $leaderNid, $staffNids)
    {
        //更新工作人員
        //取得工作人員時，僅留下沒有在其他社團擔任工作人員的學生
        /** @var Collection|Student[] $staffs */
        $staffs = Student::whereIn('nid', $staffNids)->whereHas('clubs', function ($query) use ($club) {
            /** @var Builder $query */
            $query->where('club_id', '<>', $club->id);
        }, 0)->get();
        foreach ($staffs as $staff) {
            //若已有社團，先清空
            if ($staff->clubs()->count() > 0) {
                $staff->clubs()->sync([]);
            }
        }
        $club->students()->sync($staffs->pluck('nid'));

        //更新社長
        //取得工作人員時，僅留下沒有在其他社團擔任工作人員的學生
        /** @var Student $leader */
        $leader = Student::where('nid', $leaderNid)->whereHas('clubs', function ($query) use ($club) {
            /** @var Builder $query */
            $query->where('club_id', '<>', $club->id);
        }, 0)->first();
        //若已有社團，先清空
        if ($leader && $leader->clubs()->count() > 0) {
            $leader->clubs()->sync([]);
        }
        $club->leaders()->sync($leader ? [$leader->nid => ['is_leader' => true]] : []);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Club  $club
     * @return Response
     */
    public function edit(Club $club)
    {
        return view('club.edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Club  $club
     * @param  ImgurImageService  $imgurImageService
     * @param  HTMLService  $HTMLService
     * @return Response
     *
     * @throws ValidationException
     * @throws Exception
     */
    public function update(Request $request, Club $club, ImgurImageService $imgurImageService, HTMLService $HTMLService)
    {
        $this->validate($request, [
            'number'          => 'nullable',
            'name'            => 'required',
            'club_type_id'    => 'nullable|exists:club_types,id',
            'description'     => 'nullable|strip_max:600',
            'extra_info'      => 'nullable|strip_max:600',
            'url'             => 'nullable|url',
            'image_file'      => 'image',
            'custom_question' => 'nullable|max:255',
        ]);

        $club->update(array_merge($request->all(), [
            'number'      => strtoupper($request->get('number')),
            'description' => $HTMLService->clean($request->get('description')),
            'extra_info'  => $HTMLService->clean($request->get('extra_info')),
        ]));

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

        //更新攤位
        $oldBoothIds = (array) $club->booths->pluck('id')->toArray();
        $newBoothIds = (array) $request->get('booth_id');
        $detachBoothIds = array_diff($oldBoothIds, $newBoothIds);
        $attachBoothIds = array_diff($newBoothIds, $oldBoothIds);

        /** @var User[] $detachUsers */
        $detachBooths = Booth::whereIn('id', $detachBoothIds)->get();
        foreach ($detachBooths as $detachBooth) {
            $detachBooth->club()->dissociate();
            $detachBooth->save();
        }
        $attachBooths = Booth::whereDoesntHave('club')->whereIn('id', $attachBoothIds)->get();
        $club->booths()->saveMany($attachBooths);

        //更新工作人員＆社長
        $staffNids = (array) $request->get('staff_nid');
        $leaderNid = $request->get('leader_nid');
        $this->updateStaff($club, $leaderNid, $staffNids);

        return redirect()->route('clubs.show', $club)->with('success', '社團已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Club  $club
     * @return Response
     *
     * @throws Exception
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return redirect()->route('club.index')->with('success', '社團已刪除');
    }

    public function getImport()
    {
        return view('club.import');
    }

    /**
     * @param  Request  $request
     * @param  FileService  $fileService
     * @param  StudentService  $studentService
     * @return RedirectResponse
     *
     * @throws ValidationException
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
        $invalidNidCount = 0;
        foreach ($spreadsheet->getAllSheets() as $sheetId => $sheet) {
            foreach ($sheet->getRowIterator() as $rowNumber => $row) {
                //忽略第一列
                if ($rowNumber == 1) {
                    continue;
                }
                //該列資料
                $rowData = [];
                for ($col = 1; $col <= 11; $col++) {
                    $cell = $sheet->getCellByColumnAndRow($col, $row->getRowIndex());
                    $colData = $cell->getValue();
                    if (!($colData instanceof RichText)) {
                        $colData = trim($cell->getFormattedValue());
                    }
                    $rowData[] = $colData;
                }
                //資料
                $name = $rowData[0];
                $number = strtoupper($rowData[1]);
                $clubTypeName = $rowData[2];
                $boothName = $rowData[3];
                $leaderNid = $rowData[4];
                $staffNids = [];
                for ($i = 0; $i < 6; $i++) {
                    $staffNids[$i] = strtoupper($rowData[$i + 5]);
                }

                //資料必須齊全
                if (empty($name)) {
                    $skipCount++;
                    continue;
                }
                //社團類型
                if (!empty($clubTypeName)) {
                    /** @var ClubType $clubType */
                    $clubType = ClubType::firstOrCreate([
                        'name' => $clubTypeName,
                    ], [
                        'color'      => '#000000',
                        'is_counted' => true,
                    ]);
                }

                //建立社團
                /** @var Club $club */
                $club = Club::updateOrCreate([
                    'name' => $name,
                ], [
                    'number'       => $number,
                    'club_type_id' => isset($clubType) ? $clubType->id : null,
                ]);

                //攤位
                /** @var Booth $booth */
                $booth = Booth::whereName($boothName)->first();
                if ($booth) {
                    $booth->update(['club_id' => $club->id]);
                }

                //確保社長與工作人員皆有Student
                $allStaffNids = array_filter(array_merge([$leaderNid], $staffNids));
                foreach ($allStaffNids as $nid) {
                    //試著找出學生
                    /** @var Student $student */
                    $student = $studentService->findByNid($nid);
                    if (!$student) {
                        //NID無效
                        $invalidNidCount++;
                        continue;
                    }
                }

                //更新工作人員＆社長
                $this->updateStaff($club, $leaderNid, $staffNids);

                $successCount++;
            }
        }

        return redirect()->route('club.index')
            ->with('success', "匯入完成(成功:{$successCount}/跳過:{$skipCount}/NID無效:{$invalidNidCount})");
    }

    public function downloadImportSample()
    {
        $path = resource_path('sample/club_import_sample.xlsx');

        return response()->download($path);
    }
}
