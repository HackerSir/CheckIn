@extends('layouts.app')

@section('title', 'QR Code')

@section('content')
    <div class="mt-3 pb-3">
        <h1>QR Code</h1>
        <a href="{{ route('qrcode.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增 QR Code
        </a>
        <a href="{{ route('qrcode.bind') }}" class="btn btn-primary">
            <i class="fa fa-link" aria-hidden="true"></i> 綁定 QR Code
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
