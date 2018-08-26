@extends('layouts.base')

@section('title', '我的回饋資料')

@section('buttons')
    @if($user->club)
        <a href="{{ route('feedback.index') }}" class="btn btn-secondary">
            <i class="far fa-comments"></i> 回饋資料管理
        </a>
    @endif
@endsection

@section('main_content')
    @php
        $feedbackCreateExpiredAt = new \Carbon\Carbon(Setting::get('feedback_create_expired_at'));
        $feedbackDownloadExpiredAt = new \Carbon\Carbon(Setting::get('feedback_download_expired_at'));
    @endphp
    <div class="alert alert-warning my-1">
        填寫截止時間：{{ $feedbackCreateExpiredAt }}（{{ $feedbackCreateExpiredAt->diffForHumans() }}）<br/>
        檢視截止時間：{{ $feedbackDownloadExpiredAt }}（{{ $feedbackDownloadExpiredAt->diffForHumans() }}）
    </div>
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
