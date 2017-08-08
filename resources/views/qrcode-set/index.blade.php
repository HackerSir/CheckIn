@extends('layouts.app')

@section('title', 'QR Code 集')

@section('content')
    <div class="mt-3 pb-3">
        <a href="{{ route('qrcode.index') }}" class="btn btn-secondary mb-2">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code
        </a>
        <div class="card mt-1">
            <div class="card-block">
                <h1>QR Code 集</h1>
                <p>批次建立QR Code</p>
                <a href="{{ route('qrcode-set.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增 QR Code 集
                </a>
                {!! $dataTable->table(['table' => 'mb-2']) !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
