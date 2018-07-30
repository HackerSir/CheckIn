@extends('layouts.app')

@section('title', '打卡紀錄管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>打卡紀錄管理</h1>
        {!! Form::open(['route' => ['export.record'], 'style' => 'display: inline']) !!}
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-download" aria-hidden="true"></i> 匯出
        </button>
        {!! Form::close() !!}
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
