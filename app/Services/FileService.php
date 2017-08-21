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
use Yish\Generators\Foundation\Service\Service;

class FileService extends Service
{
    /**
     * 產生檔案，doc
     *
     * @link https://github.com/PHPOffice/PHPWord 套件專案
     * @link http://phpword.readthedocs.org/ 開發�
     * 文件
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
     * 從檔案載�
     * �試算表
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
}
