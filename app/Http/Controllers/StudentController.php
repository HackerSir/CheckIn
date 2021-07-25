<?php

namespace App\Http\Controllers;

use App\DataTables\StudentsDataTable;
use App\Http\Requests\StudentRequest;
use App\Imports\StudentImport;
use App\Models\Booth;
use App\Models\Feedback;
use App\Models\Student;
use App\Services\LogService;
use App\Services\StudentService;
use Excel;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laratrust;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentController extends Controller
{
    /**
     * @var StudentService
     */
    private $studentService;
    /**
     * @var LogService
     */
    private $logService;

    /**
     * StudentController constructor.
     * @param StudentService $studentService
     * @param LogService $logService
     */
    public function __construct(StudentService $studentService, LogService $logService)
    {
        $this->studentService = $studentService;
        $this->logService = $logService;

        $this->authorizeResource(Student::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param StudentsDataTable $dataTable
     * @return JsonResponse|Response|View
     */
    public function index(StudentsDataTable $dataTable)
    {
        return $dataTable->render('student.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     * @return RedirectResponse
     */
    public function store(StudentRequest $request)
    {
        $student = Student::create(array_merge($request->all(), [
            'consider_as_freshman' => $request->exists('consider_as_freshman'),
            'is_dummy'             => true,
        ]));

        //Log
        $operator = auth()->user();
        $this->logService->info("[Student][Create] {$operator->name} 新增了 {$student->display_name}", [
            'ip'       => request()->ip(),
            'operator' => $operator,
            'student'  => $student,
        ]);

        return redirect()->route('student.index')->with('success', '學生已新增');
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function createRealStudent()
    {
        $this->authorize('create', Student::class);

        return view('student.create-real-student');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function storeRealStudent(Request $request)
    {
        $this->authorize('create', Student::class);

        $this->validate($request, [
            'nid' => [
                'required',
                'regex:#^[a-zA-Z]\d+$#',
                //                'unique:students,nid',
            ],
        ]);
        $nid = trim(Str::upper($request->get('nid')));
        $isExistsBefore = Student::whereNid($nid)->exists();
        $student = $this->studentService->updateOrCreate($nid);
        if (!$student) {
            return back()->with('warning', '查無此人');
        }
        //使用者
//        $this->userService->findOrCreateAndBind($student);

        if ($isExistsBefore) {
            $message = '學生資料已存在，已更新學生資料';
            $verbInLog = '更新';
        } else {
            $message = '學生資料已新增';
            $verbInLog = '新增';
        }
        //Log
        $operator = auth()->user();
        $this->logService->info("[Student][Create] {$operator->name} {$verbInLog}了 {$student->display_name}", [
            'ip'       => request()->ip(),
            'operator' => $operator,
            'student'  => $student,
        ]);

        return redirect()->route('student.show', $student)->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(Student $student)
    {
        $student->load('records.club.clubType', 'records.club.booths', 'qrcodes.student');

        if (Laratrust::isAbleTo('student-path.view') && request()->exists('path')) {
            $boothData = [];
            $booths = Booth::with('club.clubType')->get();
            /** @var Booth $booth */
            foreach ($booths as $booth) {
                $boothData[] = [
                    'name'      => $booth->name,
                    'longitude' => $booth->longitude,
                    'latitude'  => $booth->latitude,
                    'club_name' => $booth->name . ($booth->club ? '<br/>' . $booth->club->name : ''),
                    'fillColor' => $booth->club->clubType->color ?? '#00DD00',
                    'url'       => is_null($booth->club) ? null : route('clubs.show', $booth->club->id),
                ];
            }
            view()->share(compact('boothData'));

            $path = [];
            $records = $student->records->reverse();
            foreach ($records as $record) {
                if ($record->club->booths->count()) {
                    /** @var Booth $booth */
                    $booth = $record->club->booths->first();
                    $path[] = [
                        'lat' => $booth->latitude,
                        'lng' => $booth->longitude,
                    ];
                }
            }
            view()->share(compact('path'));
        }

        //相關的回饋資料
        $feedback = Feedback::where('student_nid', $student->nid)->select(['id', 'club_id'])
            ->get()->keyBy('club_id');

        return view('student.show', compact('student', 'feedback'));
    }

    /**
     * @param Student $student
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentRequest $request
     * @param Student $student
     * @return RedirectResponse
     */
    public function update(StudentRequest $request, Student $student)
    {
        $updateData = array_merge($request->except(['is_dummy']), [
            'consider_as_freshman' => $request->exists('consider_as_freshman'),
        ]);
        //實際資料，僅能修改視為新生選項
        if (!$student->is_dummy) {
            $updateData = Arr::only($updateData, ['consider_as_freshman']);
        }
        $student->update($updateData);

        return redirect()->route('student.show', $student)->with('success', '學生資料已更新');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Student $student
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function fetch(Student $student)
    {
        $this->authorize('fetch', $student);
        $student = $this->studentService->updateOrCreate($student->nid);
        if (!$student) {
            return back()->with('warning', '無法更新資料');
        }

        return redirect()->route('student.show', $student)->with('success', '學生資料已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Student $student
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index')
            ->with('success', '學生資料已刪除。');
    }

    /**
     * Show import form
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function getImport()
    {
        $this->authorize('import', Student::class);

        return view('student.import');
    }

    /**
     * Import data
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function postImport(Request $request)
    {
        $this->authorize('import', Student::class);
        //檢查匯入檔案格式為xls或xlsx
        $this->validate($request, [
            'import_file' => 'required|mimes:xls,xlsx',
        ]);
        //匯入檔案
        $import = new StudentImport();
        Excel::import($import, request()->file('import_file'));

        return redirect()->route('student.import')
            ->with(
                'success',
                "匯入完成（成功：{$import->successCount} 筆，略過：{$import->skipCount} 筆，失敗：{$import->failedCount} 筆）"
            );
    }

    /**
     * Download sample file of import
     *
     * @return BinaryFileResponse
     * @throws AuthorizationException
     */
    public function downloadImportSample()
    {
        $this->authorize('import', Student::class);
        $path = resource_path('import-sample/student.xlsx');

        return response()->download($path);
    }
}
