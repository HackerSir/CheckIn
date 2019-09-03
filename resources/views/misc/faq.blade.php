@extends('layouts.base')

@section('title', '常見問題')

@section('main_content')
    <p class="text-right">更新日期：2019年09月03日</p>
    <div class="card">
        <div class="card-body">
            <h3>如何進行集點？</h3>
            <p>使用NID在本站登入後，即可於首頁看到自己專屬的 QR Code，持手機至各攤位出示 QR Code，攤位人員將會為您掃描進行打卡集點動作。</p>
        </div>
        <div class="card-body">
            <h3>沒有智慧型手機或沒有網路，該如何集點？</h3>
            <p>請向服務台領取紙本 QR Code，持該紙本 QR Code至各攤位進行集點動作。</p>
        </div>
        <div class="card-body">
            <h3>該如何掃描QR Code？</h3>
            <p>可以使用本網站提供的網頁版條碼掃描器、手機相機內建的條碼掃描器、LINE 的條碼掃描器，或自行安裝 QR Code 掃描器使用。</p>
            <ul>
                <li>{{ link_to_route('qrcode.web-scan', '網站內建的網頁版條碼掃描器') }}</li>
                <li>Android：推薦使用 <a href="https://play.google.com/store/apps/details?id=com.google.zxing.client.android"
                                    target="_blank">條碼掃描器</a></li>
                <li>iOS：推薦使用 <a
                        href="https://itunes.apple.com/tw/app/quickmark-qrcode-%E6%8E%83%E6%8F%8F%E5%99%A8/id384883554?l=zh&mt=8"
                        target="_blank">QuickMark - QRCode 掃描器</a></li>
            </ul>
        </div>
        <div class="card-body">
            <h3>為什麼有些功能無法使用？</h3>
            <p>您可能不是使用瀏覽器訪問此網站，受限於您所使用的軟體，有可能會導致<b>打卡通知</b>、<b>校內導航</b>等重要功能無法正確運作。<br/>
                建議您使用功能較完善的瀏覽器訪問 {{ link_to('/', url('/')) }}。</p>
            <ul>
                <li>Android：推薦使用 <a href="https://play.google.com/store/apps/details?id=com.android.chrome"
                                    target="_blank">Google Chrome：速度與安全兼具</a></li>
                <li>iOS：推薦使用 <a href="https://itunes.apple.com/tw/app/google-chrome/id535886823?mt=8"
                                target="_blank">Google Chrome</a></li>
            </ul>
        </div>
        <div class="card-body">
            <h3>若有其他疑問，該如何求助？</h3>
            <p>可親至各服務台尋求協助，或線上聯繫<a href="https://m.me/HackerSir.tw" target="_blank">逢甲大學黑客社</a>。</p>
        </div>
    </div>
@endsection
