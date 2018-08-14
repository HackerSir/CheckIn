<?php

namespace App\Services;

use App\Qrcode;
use App\QrcodeSet;
use DNS1D;
use DNS2D;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

class FileService
{
    /**
     * 產生檔案，doc
     *
     * @link https://github.com/PHPOffice/PHPWord 套件專案
     * @link http://phpword.readthedocs.org/ 開發者文件
     *
     * @param QrcodeSet $qrcodeSet
     * @return PhpWord
     */
    public function generateQRCodeDocFile(QrcodeSet $qrcodeSet)
    {
        //建立檔案
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('微軟正黑體');
        //建立Section
        foreach ($qrcodeSet->qrcodes as $qrcode) {
            $phpWord = $this->generateQRCodeSection($phpWord, $qrcode);
        }

        return $phpWord;
    }

    private function generateQRCodeSection(PhpWord $phpWord, Qrcode $qrcode)
    {
        //建立Section
        $section = $phpWord->addSection();
        $section->setStyle([
            'marginTop'    => 50,
            'marginBottom' => 20,
        ]);
        //活動標題
        $section->addText('學生社團博覽會', ['size' => 40], ['alignment' => Jc::CENTER]);
        $section->addText('打卡集點抽獎', ['size' => 54], ['alignment' => Jc::CENTER]);

        //QR Code
        $scanUrl = route('qrcode.scan', $qrcode->code);
        $qrcodePath = DNS2D::getBarcodePNGPath($scanUrl, 'QRCODE', 18, 18);
        $section->addImage($qrcodePath, ['alignment' => Jc::CENTER]);
        $section->addTextBreak(1, ['size' => 8], ['alignment' => Jc::CENTER]);
        //BarCode
        $BarCodePath = DNS1D::getBarcodePNGPath($qrcode->code, 'C128B', 4, 90);
        $section->addImage($BarCodePath, ['alignment' => Jc::CENTER]);
        //Code
        $section->addText($qrcode->code, ['size' => 66], ['alignment' => Jc::CENTER]);

        return $phpWord;
    }

    /**
     * 從檔案載入試算表
     *
     * @param $filePath
     * @return null|Spreadsheet
     */
    public function loadSpreadsheet($filePath)
    {
        $spreadsheet = null;
        try {
            $spreadsheet = IOFactory::load($filePath);
        } catch (\Exception $exception) {
            return null;
        }

        return $spreadsheet;
    }

    public function imgurUploadMaxSize()
    {
        $maxBytes = min($this->fileUploadMaxBytes(), $this->parseSize('20MB'));

        return $this->formatBytes($maxBytes);
    }

    public function fileUploadMaxSize()
    {
        return $this->formatBytes($this->fileUploadMaxBytes());
    }

    public function fileUploadMaxBytes()
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = $this->parseSize(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = $this->parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }

        return $max_size;
    }

    public function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= (1 << (10 * $pow));
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
