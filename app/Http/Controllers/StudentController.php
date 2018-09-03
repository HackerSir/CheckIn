<?php

namespace App\Http\Controllers;

use App\Booth;
use App\DataTables\StudentsDataTable;
use App\Services\FcuApiService;
use App\Services\LogService;
use App\Services\StudentService;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * @param FcuApiService $fcuApiService
     * @param StudentService $studentService
     * @param LogService $logService
     */
    public function __construct(StudentService $studentService, LogService $logService)
    {
        $this->studentService = $studentService;
        $this->logService = $logService;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nid' => [
                'required',
                'unique:students,nid',
                'regex:#^[a-zA-Z]\d+$#',
            ],
        ]);

        $student = $this->studentService->updateOrCreate($request->get('nid'));
        if (!$student) {
            return back()->with('warning', '查無此人');
        }

        //使用者
        if (!$student->user) {
            $email = $student->nid . '@fcu.edu.tw';
            /** @var User $user */
            $user = User::query()->firstOrCreate([
                'email' => $email,
            ], [
                'name'        => $student->name,
                'password'    => '',
                'confirm_at'  => Carbon::now(),
                'register_at' => Carbon::now(),
                'register_ip' => \Request::getClientIp(),
            ]);
            $user->student()->save($student);
        }

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
                    'club_name' => $booth->club->name ?? '（空攤位）',
                    'fillColor' => $booth->club->clubType->color ?? '#00DD00',
                    'url'       => is_null($booth->club) ? null : route('clubs.show', $booth->club->id),
                ];
            }

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
        }

        return view('student.show', compact('student', 'boothData', 'path'));
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
     * @param  \App\Student $student
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Student $student, Request $request)
    {
        $student->update([
            'consider_as_freshman' => $request->exists('consider_as_freshman'),
        ]);

        return redirect()->route('student.show', $student)->with('success', '學生資料已更新');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function fetch(Student $student)
    {
        $student = $this->studentService->updateOrCreate($student->nid);
        if (!$student) {
            return back()->with('warning', '無法更新資料');
        }

        return redirect()->route('student.index')->with('success', '學生已更新');
    }
}
