@extends('layouts.app')

@section('title', '回饋資料')

@section('content')
    <div class="mt-3 pb-3">
        <h1>回饋資料</h1>
        @php
            $feedbackCreateExpiredAt = new \Carbon\Carbon(Setting::get('feedback_create_expired_at'));
            $feedbackDownloadExpiredAt = new \Carbon\Carbon(Setting::get('feedback_download_expired_at'));
        @endphp
        <div class="alert alert-warning">
            填寫截止時間：{{ $feedbackCreateExpiredAt }}（{{ $feedbackCreateExpiredAt->diffForHumans() }}）<br/>
            檢視截止時間：{{ $feedbackDownloadExpiredAt }}（{{ $feedbackDownloadExpiredAt->diffForHumans() }}）
        </div>
        @if(\Laratrust::can('feedback.manage') || (auth()->user() && auth()->user()->club))
            {!! Form::open(['route' => ['export.feedback'], 'style' => 'display: inline']) !!}
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download" aria-hidden="true"></i> 匯出
            </button>
            {!! Form::close() !!}
        @endif
        <div class="card mt-1">
            <div class="card-body">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
