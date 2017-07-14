@extends('layouts.app')

@section('title', '學生管理')

@section('content')
    <h1>學生管理</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
