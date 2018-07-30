@extends('layouts.app')

@section('title', '社團管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>社團管理</h1>
        <a href="{{ route('club.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增社團
        </a>
        <a href="{{ route('club.import') }}" class="btn btn-primary">
            <i class="fa fa-upload" aria-hidden="true"></i> 匯入
        </a>
        {!! Form::open(['route' => ['export.club-staff'], 'style' => 'display: inline']) !!}
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-download" aria-hidden="true"></i> 匯出攤位負責人
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
