@extends('layouts.base')

@section('title', '學生管理')

@section('buttons')
    <a href="{{ route('student.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增學生
    </a>
@endsection

@section('container_class', 'container-fluid')
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
