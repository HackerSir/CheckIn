@extends('layouts.app')

@section('title', 'QR Code 集')

@section('content')
    <div class="mt-3 pb-3">
        <a href="{{ route('qrcode.index') }}" class="btn btn-secondary mb-2">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code
        </a>
        <h1>QR Code 集</h1>
        <div class="card mt-1">
            <div class="card-block">
                <a href="{{ route('qrcode-set.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增 QR Code 集
                </a>
                <div class="mt-2">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
