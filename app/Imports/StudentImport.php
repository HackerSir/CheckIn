<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Validator;

class StudentImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    public $successCount = 0;
    public $skipCount = 0;
    public $failedCount = 0;

    /**
     * StudentImport constructor.
     */
    public function __construct()
    {
        //令欄位名稱不經過 str_slug 轉換，確保中文欄位名稱不會遺失
        HeadingRowFormatter::default('none');
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //FIXME: 單一檔案出現重複NID時，會導致無法匯入
        //欄位
        $fields = [
            'nid'       => strtoupper($row['NID']),
            'name'      => $row['姓名'],
            'class'     => $row['班級'],
            'type'      => $row['類型'],
            'unit_id'   => $row['科系ID'],
            'unit_name' => $row['科系'],
            'dept_id'   => $row['學院ID'],
            'dept_name' => $row['學院'],
            'in_year'   => $row['入學年度'],
            'gender'    => $row['性別'],
            'is_dummy'  => true,
        ];
        //驗證
        if (Validator::make($fields, [
            'nid'       => ['required', 'regex:/^[a-z]\d+$/i'],
            'name'      => 'nullable',
            'class'     => 'nullable',
            'type'      => 'nullable',
            'unit_id'   => 'nullable',
            'unit_name' => 'nullable',
            'dept_id'   => 'nullable',
            'dept_name' => 'nullable',
            'in_year'   => 'nullable|integer',
            'gender'    => 'nullable',
        ])->fails()) {
            $this->failedCount++;

            return null;
        }

        $student = Student::whereNid($fields['nid'])->first();
        if ($student) { //若已有資料
            if (!$student->is_dummy) {
                //已有實際資料，略過不處理
                $this->skipCount++;

                return null;
            }
            // 更新資料
            $student->update($fields);
            $this->successCount++;

            return null;
        }
        $this->successCount++;

        return new Student($fields);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }
}
