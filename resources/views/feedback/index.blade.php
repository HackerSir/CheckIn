@extends('layouts.base')

@section('title', '回饋資料')

@section('container_class', 'container-fluid')
@section('buttons')
    @if($user->student)
        <a href="{{ route('feedback.my') }}" class="btn btn-secondary">
            <i class="far fa-comment mr-2"></i>我的回饋資料
        </a>
    @endif
    @if(\Laratrust::isAbleTo('feedback.manage') || $user->club)
        {!! Form::open(['route' => ['export.feedback'], 'style' => 'display: inline']) !!}
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-download mr-2"></i>匯出
        </button>
        {!! Form::close() !!}
    @endif
@endsection

@section('main_content')
    @include('feedback.time-range')
    @if(\Laratrust::isAbleTo('feedback.manage') || $user->club)
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
