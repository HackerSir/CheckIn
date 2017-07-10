@extends('layouts.app')

@section('title', '會員清單')

@section('content')
    <h1>會員清單</h1>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
