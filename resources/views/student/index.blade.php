@extends('layouts.app')

@section('title', '學生管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>學生管理</h1>
        <a href="{{ route('student.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增學生
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
