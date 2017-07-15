@extends('layouts.app')

@section('title', 'QR Code')

@section('content')
    <h1>QR Code</h1>
    <a href="{{ route('qrcode.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增 QR Code
    </a>
    <div class="card mt-1">
        <div class="card-block">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
