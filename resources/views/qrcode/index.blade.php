@extends('layouts.app')

@section('title', 'QR Code')

@section('content')
    <div class="mt-3 pb-3">
        <h1>QR Code</h1>
        <a href="{{ route('qrcode.bind') }}" class="btn btn-primary">
            <i class="fa fa-link" aria-hidden="true"></i> 綁定 QR Code
        </a>
        @if(Laratrust::can('qrcode-set.manage'))
            <a href="{{ route('qrcode-set.index') }}" class="btn btn-primary">
                <i class="fa fa-list" aria-hidden="true"></i> QR Code 集
            </a>
        @endif
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
