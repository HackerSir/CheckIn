@extends('layouts.app')

@section('title', '會員清單')

@section('content')
    <div class="mt-3 pb-3">
        <h1>會員清單</h1>
        <div class="card">
            <div class="card-block">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
