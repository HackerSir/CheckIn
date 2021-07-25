@extends('layouts.base')

@section('title', 'QR Code 集')

@section('buttons')
    @if(Laratrust::isAbleTo('qrcode.manage'))
        <a href="{{ route('qrcode.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left mr-2"></i>QR Code
        </a>
    @endif
    <a href="{{ route('qrcode-set.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle mr-2"></i>新增 QR Code 集
    </a>
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
