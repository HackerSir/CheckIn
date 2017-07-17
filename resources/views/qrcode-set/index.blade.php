@extends('layouts.app')

@section('title', 'QR Code 集')

@section('content')
    <div class="mt-3 pb-3">
        <h1>QR Code 集</h1>
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
