<?php

namespace App\Http\Controllers;

use App\Club;
use App\Record;
use App\Student;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet;

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

        //下載
        return $this->downloadSpreadsheet($spreadsheet, '打卡紀錄.xlsx');
    }
}
