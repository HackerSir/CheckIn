@extends('layouts.app')

@section('title', '會員清單')

@section('content')
    <h1>會員清單</h1>
    <div class="card">
        <div class="card-block">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
