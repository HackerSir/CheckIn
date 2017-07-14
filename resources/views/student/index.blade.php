@extends('layouts.app')

@section('title', '學生管理')

@section('content')
    <h1>學生管理</h1>
    <a href="{{ route('student.create') }}" class="btn btn-primary">
        新增學生
    </a>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
