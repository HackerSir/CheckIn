@extends('layouts.base')

@section('title', 'QR Code')

@section('buttons')
    <a href="{{ route('qrcode.bind') }}" class="btn btn-primary">
        <i class="fa fa-link mr-2"></i>綁定 QR Code
    </a>
    @if(Laratrust::can('qrcode-set.manage'))
        <a href="{{ route('qrcode-set.index') }}" class="btn btn-primary">
            <i class="fa fa-list mr-2"></i>QR Code 集
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
