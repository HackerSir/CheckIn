@extends('layouts.app')

@section('title', '回饋資料')

@section('content')
    <div class="mt-3 pb-3">
        <h1>回饋資料</h1>
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
