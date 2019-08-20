@extends('layouts.base')

@section('title', '打卡紀錄管理')

@section('buttons')
    {!! Form::open(['route' => ['export.record'], 'style' => 'display: inline']) !!}
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-download mr-2"></i>匯出
    </button>
    {!! Form::close() !!}
@endsection

@section('main_content')
    <div class="card mt">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
