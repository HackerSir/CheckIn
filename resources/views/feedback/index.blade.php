@extends('layouts.app')

@section('title', '回饋資料')

@section('content')
    <div class="mt-3 pb-3">
        <h1>回饋資料</h1>
        @if(\Laratrust::can('feedback.manage') || (auth()->user() && auth()->user()->club))
        {!! Form::open(['route' => ['export.feedback'], 'style' => 'display: inline']) !!}
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-download" aria-hidden="true"></i> 匯出
        </button>
        {!! Form::close() !!}
        @endif
        <div class="card mt-1">
            <div class="card-block">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
