@extends('layouts.base')

@section('title', '回饋資料')

@section('buttons')
    @if(\Laratrust::can('feedback.manage') || $user->club)
        {!! Form::open(['route' => ['export.feedback'], 'style' => 'display: inline']) !!}
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-download" aria-hidden="true"></i> 匯出
        </button>
        {!! Form::close() !!}
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
    @if(\Laratrust::can('feedback.manage') || $user->club)
        <div class="alert alert-info my-1">
            {{ optional($user->club)->name }}
            <ul class="mb-0">
                <li>回饋資料：{{ $feedbackCount }}（約佔打卡人數 {{ $countProportion }}%）</li>
                <li>打卡人數：{{ $recordCount }}</li>
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
