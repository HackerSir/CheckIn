<?php

namespace App\Http\Controllers;

use App\Booth;
use App\DataTables\StudentsDataTable;
use App\Http\Requests\StudentRequest;
use App\Services\LogService;
use App\Services\StudentService;
use App\Services\UserService;
use App\Student;
use Illuminate\Support\Arr;

class StudentController extends Controller
{
    /**
     * @var StudentService
     */
    private $studentService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var LogService
     */
    private $logService;

    /**
     * StudentController constructor.
     * @param StudentService $studentService
     * @param UserService $userService
     * @param LogService $logService
     */
    public function __construct(StudentService $studentService, UserService $userService, LogService $logService)
    {
        $this->studentService = $studentService;
        $this->userService = $userService;
        $this->logService = $logService;

        $this->authorizeResource(Student::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param StudentsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(StudentsDataTable $dataTable)
    {
        return $dataTable->render('student.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StudentRequest $request)
    {
        $this->validate($request, [
            'nid' => [
                'required',
                'unique:students,nid',
                'regex:#^[a-zA-Z]\d+$#',
            ],
        ]);

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
     * Display the specified resource.
     *
     * @param Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $student->load('records.club.clubType', 'records.club.booths', 'qrcodes.student');

        if (\Laratrust::can('student-path.view') && request()->exists('path')) {
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

        return view('student.show', compact('student'));
    }

    /**
     * @param Student $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentRequest $request
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param Student $student
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index')
            ->with('success', '學生資料已刪除。');
    }
}
