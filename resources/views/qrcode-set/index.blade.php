@extends('layouts.app')

@section('title', 'QR Code 集')

@section('content')
    <div class="mt-3 pb-3">
        <h1>QR Code 集</h1>
        <a href="{{ route('qrcode-set.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增 QR Code 集
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
