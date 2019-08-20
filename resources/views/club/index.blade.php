@extends('layouts.base')

@section('title', '社團管理')

@section('buttons')
    <a href="{{ route('club.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle mr-2"></i>新增社團
    </a>
    <a href="{{ route('club.import') }}" class="btn btn-primary">
        <i class="fa fa-upload mr-2"></i>匯入
    </a>
    {!! Form::open(['route' => ['export.club'], 'style' => 'display: inline']) !!}
    <button type="submit" class="btn btn-success">
        <i class="fa fa-download mr-2"></i>匯出社團
    </button>
    {!! Form::close() !!}
    {!! Form::open(['route' => ['export.club-staff'], 'style' => 'display: inline']) !!}
    <button type="submit" class="btn btn-success">
        <i class="fa fa-download mr-2"></i>匯出攤位負責人
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
