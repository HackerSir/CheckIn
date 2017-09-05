@extends('layouts.app')

@section('title', '常見問題')

@section('content')
    <div class="mt-3 pb-3">
        <h1>常見問題</h1>
        <p class="text-right">更新日期：2017年09月05日</p>
        <div class="card">
            <div class="card-block">
                <h3>如何進行集點？</h3>
                <p>在本站登入NID後，即可於首頁看到自己專屬的QR Code，持手機至各攤位出示QR Code，攤位人員將會為您掃描進行打卡集點動作。</p>
            </div>
            <div class="card-block">
                <h3>沒有智慧型手機或沒有網路，該如何集點？</h3>
                <p>請向服務台領取紙本QR Code，持該紙本QR Code至各攤位進行集點動作。</p>
            </div>
            <div class="card-block">
                <h3>該如何掃描QR Code？</h3>
                <p>可以使用LINE的條碼掃描器，或自行安裝QR Code掃描器使用。<br/>
                    Android：推薦使用 <a href="https://play.google.com/store/apps/details?id=com.google.zxing.client.android"
                                 target="_blank">條碼掃描器</a><br/>
                    iOS：推薦使用 <a
                        href="https://itunes.apple.com/tw/app/quickmark-qrcode-%E6%8E%83%E6%8F%8F%E5%99%A8/id384883554?l=zh&mt=8"
                        target="_blank">QuickMark - QRCode 掃描器</a>
                </p>
            </div>
            <div class="card-block">
                <h3>若有其他疑問，該如何求助？</h3>
                <p>可親至各服務台尋求協助，或線上聯繫<a href="https://m.me/HackerSir.tw" target="_blank">逢甲大學黑客社</a>。</p>
            </div>
        </div>
    </div>
@endsection
