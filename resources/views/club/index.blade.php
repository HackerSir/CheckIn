@extends('layouts.app')

@section('title', '社團管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>社團管理</h1>
        <a href="{{ route('club.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增社團
        </a>
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
