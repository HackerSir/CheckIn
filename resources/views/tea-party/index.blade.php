@extends('layouts.base')

@section('title', '迎新茶會管理')

@section('buttons')
    <a href="{{ route('tea-party.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle mr-2"></i>新增迎新茶會
    </a>
    {!! Form::open(['route' => ['export.tea-party'], 'style' => 'display: inline']) !!}
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-download mr-2"></i>匯出
    </button>
    {!! Form::close() !!}
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
