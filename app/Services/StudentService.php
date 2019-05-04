<?php

namespace App\Services;

use App\Student;
use Carbon\Carbon;

class StudentService
{
    /**
     * @var FcuApiService
     */
    private $fcuApiService;

    /**
     * StudentService constructor.
     * @param FcuApiService $fcuApiService
     */
    public function __construct(FcuApiService $fcuApiService)
    {
        $this->fcuApiService = $fcuApiService;
    }

    /**
     * 根據NID找到學生，若找到且無本地紀錄，則一併新增
     *
     * @param string $nid 學號
     * @return Student|null 學生實體
     */
    public function findByNid($nid)
    {
        //NID轉大寫並清除外側空白
        $nid = trim(strtoupper($nid));
        //嘗試尋找學生
        $student = Student::where('nid', $nid)->first();
        if ($student) {
            //若已存在，直接回傳
            return $student;
        }
        //嘗試透過API尋找
        $student = $this->updateOrCreate($nid);

        return $student;
    }

    /**
     * 更新或新增特定NID的學生
     *
     * @param string $nid 學號
     * @return Student|null 學生實體
     */
    public function updateOrCreate($nid)
    {
        //NID轉大寫並清除外側空白
        $nid = trim(strtoupper($nid));
        //透過API取得資料
        $stuInfo = $this->fcuApiService->getStuInfo($nid);
        if (!$stuInfo) {
            //無法取得資料
            return null;
        }

        /** @var Student $student */
        $student = Student::updateOrCreate([
            'nid' => $stuInfo['stu_id'],
        ], [
            'name'      => $stuInfo['stu_name'],
            'class'     => $stuInfo['stu_class'],
            'unit_name' => $stuInfo['unit_name'],
            'dept_name' => $stuInfo['dept_name'],
            'in_year'   => $stuInfo['in_year'],
            'gender'    => $stuInfo['stu_sex'],
            'is_dummy'  => false,
            'fetch_at'  => Carbon::now(),
        ]);

        return $student;
    }

    /**
     * 更新或新增特定NID的學生
     *
     * @param array $userInfo 登入後透過 getUserInfo 取得的資訊
     * @return Student|null 學生實體
     */
    public function updateOrCreateOfUserInfo($userInfo)
    {
        //NID轉大寫並清除外側空白
        $nid = trim(strtoupper($userInfo['id']));

        /** @var Student $student */
        $student = Student::updateOrCreate([
            'nid' => $nid,
        ], [
            'name'      => $userInfo['name'],
            'class'     => $userInfo['classname'],
            'type'      => $userInfo['type'],
            'unit_id'   => $userInfo['unit_id'],
            'unit_name' => $userInfo['unit_name'],
            'dept_id'   => $userInfo['dept_id'],
            'dept_name' => $userInfo['dept_name'],
            // in_year 與 gender 來自 GetStuInfo，非該學期在校生會無法取得這兩個欄位
            'in_year'   => $userInfo['in_year'] ?? null,
            'gender'    => $userInfo['stu_sex'] ?? null,
            'is_dummy'  => false,
            'fetch_at'  => Carbon::now(),
        ]);

        return $student;
    }
}
