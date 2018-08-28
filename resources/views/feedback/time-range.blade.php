@php
    $feedbackCreateExpiredAt = new \Carbon\Carbon(Setting::get('feedback_create_expired_at'));
    $feedbackDownloadExpiredAt = new \Carbon\Carbon(Setting::get('feedback_download_expired_at'));
@endphp
<div class="alert alert-warning my-1">
    填寫截止時間：{{ $feedbackCreateExpiredAt }}（{{ $feedbackCreateExpiredAt->diffForHumans() }}）<br/>
    檢視截止時間：{{ $feedbackDownloadExpiredAt }}（{{ $feedbackDownloadExpiredAt->diffForHumans() }}）
</div>
