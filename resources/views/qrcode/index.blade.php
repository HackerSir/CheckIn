@extends('layouts.app')

@section('title', 'QR Code')

@section('content')
    <h1>QR Code</h1>
    <a href="{{ route('qrcode.create') }}" class="btn btn-primary">
        新增 QR Code
    </a>
    {!! $dataTable->table() !!}
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
