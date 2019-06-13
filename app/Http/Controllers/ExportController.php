<?php

namespace App\Http\Controllers;

use App\Club;
use App\ClubSurvey;
use App\Feedback;
use App\Record;
use App\Student;
use App\StudentSurvey;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Setting;

class ExportController extends Controller
{
    /**
     * 下載 Spreadsheet 檔案
     * @param Spreadsheet $spreadsheet 欲下載的Spreadsheet
     * @param string|null $fileName 檔名
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function downloadSpreadsheet(Spreadsheet $spreadsheet, $fileName = null)
    {
        $spreadsheet->setActiveSheetIndex(0);
        $filePath = sys_get_temp_dir() . '/CheckIn2017_export_' . time() . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return response()->download($filePath, $fileName);
    }

    /**
     * @param Worksheet $sheet
     * @param array $titles
     * @return Worksheet
     */
    private function setTitleRow(Worksheet $sheet, array $titles)
    {
        $col = 1;
        foreach ($titles as $title) {
            $sheet->setCellValueByColumnAndRow($col, 1, $title);
            $col++;
        }
        $sheet->freezePaneByColumnAndRow(1, 2);
        $styleArray = [
            'borders' => [
                'bottom' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(1, 1, $col - 1, 1)->applyFromArray($styleArray);

        return $sheet;
    }

    /**
     * @param Worksheet $sheet
     * @param array $data
     * @return Worksheet
     */
    private function appendRow(Worksheet $sheet, array $data)
    {
        $row = $sheet->getHighestRow() + 1;
        $col = 1;
        foreach ($data as $datum) {
            $sheet->setCellValueByColumnAndRow($col, $row, $datum);
            $col++;
        }

        return $sheet;
    }

    /**
     * 打卡紀錄
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function record()
    {
        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //建立匯出資料
        $this->setTitleRow(
            $sheet,
            [
                '#',
                'NID',
                '姓名',
                '班級',
                '科系',
                '學院',
                '入學年度',
                '性別',
                '新生',
                '攤位負責人',
                '社團編號',
                '社團類型',
                '社團名稱',
                '打卡時間',
            ]
        );
        $records = Record::with('student.user', 'club.clubType')->orderBy('created_at')->get();
        foreach ($records as $record) {
            /** @var Student $student */
            $student = $record->student;
            /** @var Club $club */
            $club = $record->club;
            $this->appendRow($sheet, [
                $record->id,
                $student->nid,
                $student->name,
                $student->class,
                $student->unit_name,
                $student->dept_name,
                $student->in_year,
                $student->gender,
                $student->is_freshman,
                $student->is_staff,
                $club->number,
                $club->clubType->name ?? '',
                $club->name,
                $record->created_at,
            ]);
        }
        //調整格式
        $styleArray = [
            'borders' => [
                'right' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(9, 1, 9, $sheet->getHighestRow())->applyFromArray($styleArray);
        $sheet->getStyleByColumnAndRow(12, 1, 12, $sheet->getHighestRow())->applyFromArray($styleArray);

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '打卡紀錄.xlsx');
    }

    /**
     * 回饋資料
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \Exception
     */
    public function feedback()
    {
        $feedbackQuery = Feedback::with('student.user', 'club.clubType');
        //若有管理權限，直接顯示全部
        if (!\Laratrust::can('feedback.manage')) {
            //若無管理權限
            /** @var User $user */
            $user = auth()->user();
            if ($user->club) {
                //檢查檢視與下載期限
                $feedbackDownloadExpiredAt = new Carbon(Setting::get('feedback_download_expired_at'));
                if (Carbon::now()->gt($feedbackDownloadExpiredAt)) {
                    return back()->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
                }
                //確認是否為社長
                if (!$user->club->pivot->is_leader) {
                    return back()->with('warning', '匯出功能限社長使用');
                }
                //攤位負責人看到自己社團的
                $feedbackQuery->where('club_id', $user->club->id);
            } else {
                //沒有權限
                abort(403);
            }
        }
        /** @var Feedback[]|Collection $feedback */
        $feedback = $feedbackQuery->get();

        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //建立匯出資料
        $this->setTitleRow(
            $sheet,
            [
                '#',
                'NID',
                '姓名',
                '班級',
                '科系',
                '學院',
                '入學年度',
                '性別',
                '新生',
                '攤位負責人',
                '社團編號',
                '社團類型',
                '社團名稱',
                '電話',
                '信箱',
                'Facebook',
                'LINE',
                '附加訊息',
                '社團自訂問題',
                '對於社團自訂問題的回答',
            ]
        );
        foreach ($feedback as $feedbackItem) {
            /** @var Student $student */
            $student = $feedbackItem->student;
            /** @var Club $club */
            $club = $feedbackItem->club;
            $message = $feedbackItem->message;
            if (starts_with($message, '=')) {
                $message = "'" . $message;
            }

            $this->appendRow($sheet, [
                $feedbackItem->id,
                $student->nid,
                $student->name,
                $student->class,
                $student->unit_name,
                $student->dept_name,
                $student->in_year,
                $student->gender,
                $student->is_freshman,
                $student->is_staff,
                $club->number,
                $club->clubType->name ?? '',
                $club->name,
                $feedbackItem->phone,
                $feedbackItem->email,
                $feedbackItem->facebook,
                $feedbackItem->line,
                $message,
                $feedbackItem->custom_question,
                $feedbackItem->answer_of_custom_question,
            ]);
        }
        //調整格式
        $styleArray = [
            'borders' => [
                'right' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(9, 1, 9, $sheet->getHighestRow())->applyFromArray($styleArray);
        $sheet->getStyleByColumnAndRow(12, 1, 12, $sheet->getHighestRow())->applyFromArray($styleArray);

        //若無管理權限
        if (!\Laratrust::can('feedback.manage')) {
            //移除「攤位負責人」欄位
            $sheet->removeColumn('J');
            //補回被移除的分隔線
            $sheet->getStyleByColumnAndRow(8, 1, 8, $sheet->getHighestRow())->applyFromArray($styleArray);
        }

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '回饋資料.xlsx');
    }

    /**
     * 社團清單
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function club()
    {
        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //建立匯出資料
        $this->setTitleRow(
            $sheet,
            [
                'ID',
                '社團類型',
                '社團編號',
                '名稱',
                '攤位',
                '打卡次數',
                '回饋資料',
            ]
        );
        /** @var Collection|Club[] $clubs */
        $clubs = Club::with('clubType', 'booths')->withCount('records', 'feedback')->orderBy('id')->get();
        foreach ($clubs as $club) {
            $this->appendRow($sheet, [
                $club->id,
                $club->clubType->name ?? null,
                $club->number,
                $club->name,
                implode('、', $club->booths->pluck('name')->toArray()),
                $club->records_count,
                $club->feedback_count,
            ]);
        }
        //調整格式
        $styleArray = [
            'borders' => [
                'right' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(7, 1, 7, $sheet->getHighestRow())->applyFromArray($styleArray);

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '社團.xlsx');
    }

    /**
     * 攤位負責人（僅匯出有對應學生之使用者名單）
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function clubStaff()
    {
        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //建立匯出資料
        $this->setTitleRow(
            $sheet,
            [
                'NID',
                '姓名',
                '班級',
                '科系',
                '學院',
                '入學年度',
                '性別',
                '新生',
                '社團編號',
                '社團類型',
                '社團名稱',
            ]
        );
        /** @var Collection|Student[] $students */
        $students = Student::with('clubs.clubType')->has('clubs')->get()
            ->sortBy(function ($student, $key) {
                return $student->clubs->first()->id;
            });
        foreach ($students as $student) {
            /** @var Club $club */
            $club = $student->clubs->first();
            $this->appendRow($sheet, [
                $student->nid,
                $student->name,
                $student->class,
                $student->unit_name,
                $student->dept_name,
                $student->in_year,
                $student->gender,
                $student->is_freshman,
                $club->number,
                $club->clubType->name ?? '',
                $club->name,
            ]);
        }
        //調整格式
        $styleArray = [
            'borders' => [
                'right' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(7, 1, 7, $sheet->getHighestRow())->applyFromArray($styleArray);

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '攤位負責人.xlsx');
    }

    /**
     * 學生問卷
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function studentSurvey()
    {
        $studentSurveys = StudentSurvey::with('student.user')->get();
        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //建立匯出資料
        $this->setTitleRow(
            $sheet,
            [
                '#',
                'NID',
                '姓名',
                '班級',
                '科系',
                '學院',
                '入學年度',
                '性別',
                '新生',
                '攤位負責人',
                '評價',
                '意見與建議',
            ]
        );
        foreach ($studentSurveys as $studentSurvey) {
            /** @var Student $student */
            $student = $studentSurvey->student;
            $comment = $studentSurvey->comment;
            if (starts_with($comment, '=')) {
                $comment = "'" . $comment;
            }

            $this->appendRow($sheet, [
                $studentSurvey->id,
                $student->nid,
                $student->name,
                $student->class,
                $student->unit_name,
                $student->dept_name,
                $student->in_year,
                $student->gender,
                $student->is_freshman,
                $student->is_staff,
                $studentSurvey->rating,
                $comment,
            ]);
        }
        //調整格式
        $styleArray = [
            'borders' => [
                'right' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(9, 1, 9, $sheet->getHighestRow())->applyFromArray($styleArray);

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '學生問卷.xlsx');
    }

    /**
     * 社團問卷
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function clubSurvey()
    {
        $clubSurveys = ClubSurvey::with('user', 'club.clubType')->get();
        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //建立匯出資料
        $this->setTitleRow(
            $sheet,
            [
                '#',
                'UID',
                'NID',
                '姓名',
                '班級',
                '科系',
                '學院',
                '入學年度',
                '性別',
                '新生',
                '社團編號',
                '社團類型',
                '社團名稱',
                '評價',
                '意見與建議',
            ]
        );
        foreach ($clubSurveys as $clubSurvey) {
            /** @var Club $club */
            $club = $clubSurvey->club;
            /** @var User $user */
            $user = $clubSurvey->user;
            $student = $user->student;
            $comment = $clubSurvey->comment;
            if (starts_with($comment, '=')) {
                $comment = "'" . $comment;
            }

            $this->appendRow($sheet, [
                $clubSurvey->id,
                $user->id,
                $student->nid ?? null,
                $student->name ?? $user->name,
                $student->class ?? null,
                $student->unit_name ?? null,
                $student->dept_name ?? null,
                $student->in_year ?? null,
                $student->gender ?? null,
                $student->is_freshman ?? null,
                $club->number,
                $club->clubType->name ?? null,
                $club->name,
                $clubSurvey->rating,
                $comment,
            ]);
        }
        //調整格式
        $styleArray = [
            'borders' => [
                'right' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(9, 1, 9, $sheet->getHighestRow())->applyFromArray($styleArray);

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '社團問卷.xlsx');
    }
}
