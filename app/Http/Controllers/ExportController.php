<?php

namespace App\Http\Controllers;

use App\Club;
use App\Feedback;
use App\Record;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet;
use Setting;

class ExportController extends Controller
{
    /**
     * 下載 Spreadsheet 檔案
     * @param Spreadsheet $spreadsheet 欲下載的Spreadsheet
     * @param string|null $fileName 檔名
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
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
        $col = 0;
        foreach ($titles as $title) {
            $sheet->setCellValueByColumnAndRow($col, 1, $title);
            $col++;
        }
        $sheet->freezePaneByColumnAndRow(0, 2);
        $styleArray = [
            'borders' => [
                'bottom' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyleByColumnAndRow(0, 1, $col - 1, 1)->applyFromArray($styleArray);

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
        $col = 0;
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
     */
    public function record()
    {
        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //建立匯出資料
        $this->setTitleRow(
            $sheet,
            ['#', 'NID', '姓名', '班級', '科系', '學院', '入學年度', '性別', '新生', '社團編號', '社團類型', '社團名稱', '打卡時間']
        );
        $records = Record::with('student', 'club.clubType')->orderBy('created_at')->get();
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

        $sheet->getStyleByColumnAndRow(8, 1, 8, $sheet->getHighestRow())->applyFromArray($styleArray);
        $sheet->getStyleByColumnAndRow(11, 1, 11, $sheet->getHighestRow())->applyFromArray($styleArray);

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '打卡紀錄.xlsx');
    }

    /**
     * 回饋資料
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function feedback()
    {
        $feedbackQuery = Feedback::query();
        //若有管理權限，直接顯示全部
        if (!\Laratrust::can('feedback.manage')) {
            //若無管理權限
            /** @var User $user */
            $user = auth()->user();
            if ($user->club) {
                //檢查檢視與下載期限
                $feedbackDownloadExpiredAt = new \Carbon\Carbon(Setting::get('feedback_download_expired_at'));
                if (Carbon::now()->gt($feedbackDownloadExpiredAt)) {
                    return back()->with('warning', '已超過檢視期限，若需查看資料，請聯繫各委會輔導老師');
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
            ['#', 'NID', '姓名', '班級', '科系', '學院', '入學年度', '性別', '新生', '社團編號', '社團類型', '社團名稱', '電話', '信箱', '附加訊息']
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
                $club->number,
                $club->clubType->name ?? '',
                $club->name,
                $feedbackItem->phone,
                $feedbackItem->email,
                $message,
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

        $sheet->getStyleByColumnAndRow(8, 1, 8, $sheet->getHighestRow())->applyFromArray($styleArray);
        $sheet->getStyleByColumnAndRow(11, 1, 11, $sheet->getHighestRow())->applyFromArray($styleArray);

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '回饋資料.xlsx');
    }
}
