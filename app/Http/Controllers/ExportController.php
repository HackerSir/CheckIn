<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExportController extends Controller
{
    private function generateFilePath()
    {
        return sys_get_temp_dir() . '/CheckIn2017_export_' . time() . '.xlsx';
    }

    public function record()
    {
        //建立
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //TODO: 建立匯出資料

        $spreadsheet->setActiveSheetIndex(0);
        //下載
        $filePath = $this->generateFilePath();
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return response()->download($filePath, '打卡紀錄.xlsx');

    }
}
