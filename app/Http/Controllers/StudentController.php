<?php

namespace App\Http\Controllers;

use App\Booth;
use App\DataTables\StudentsDataTable;
use App\Services\FcuApiService;
use App\Services\LogService;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * @var FcuApiService
     */
    private $fcuApiService;
    /**
     * @var LogService
     */
    private $logService;

    /**
     * StudentController constructor.
     * @param FcuApiService $fcuApiService
     * @param LogService $logService
     */
    public function __construct(FcuApiService $fcuApiService, LogService $logService)
    {
        $this->fcuApiService = $fcuApiService;
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

        $stuInfo = $this->fcuApiService->getStuInfo($request->get('nid'));
        if (!$stuInfo) {
            return back()->with('warning', '查無此人');
        }

        $student = Student::create([
            'nid'       => $stuInfo['stu_id'],
            'name'      => $stuInfo['stu_name'],
            'class'     => $stuInfo['stu_class'],
            'unit_name' => $stuInfo['unit_name'],
            'dept_name' => $stuInfo['dept_name'],
            'in_year'   => $stuInfo['in_year'],
            'gender'    => $stuInfo['stu_sex'],
        ]);

        //使用者
        if (!$student->user) {
            $email = $stuInfo['stu_id'] . '@fcu.edu.tw';
            /** @var User $user */
            $user = User::query()->updateOrCreate([
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

        return redirect()->route('student.index')->with('global', '學生已新增');
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
     * Update the specified resource in storage.
     *
     * @param  \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function update(Student $student)
    {
        $stuInfo = $this->fcuApiService->getStuInfo($student->nid);
        if (!$stuInfo) {
            return back()->with('warning', '無法更新資料');
        }

        $student->update([
            'name'      => $stuInfo['stu_name'],
            'class'     => $stuInfo['stu_class'],
            'unit_name' => $stuInfo['unit_name'],
            'dept_name' => $stuInfo['dept_name'],
            'in_year'   => $stuInfo['in_year'],
            'gender'    => $stuInfo['stu_sex'],
        ]);

        return redirect()->route('student.index')->with('global', '學生已更新');
    }
}
