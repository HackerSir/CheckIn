@extends('layouts.base')

@section('title', $qrcodeSet->id . ' - QR Code 集')

@section('buttons')
    <a href="{{ route('qrcode-set.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code 集
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-3">編號</dt>
                <dd class="col-8 col-md-9">{{ $qrcodeSet->id }}</dd>

                <dt class="col-4 col-md-3">數量</dt>
                <dd class="col-8 col-md-9">{{ $qrcodeSet->qrcodes()->count() }}</dd>

                <dt class="col-4 col-md-3">建立時間</dt>
                <dd class="col-8 col-md-9">{{ $qrcodeSet->created_at }}</dd>
            </dl>
        </div>
        <div class="card-body text-center">
            {{ Form::open(['route' => ['qrcode-set.download', $qrcodeSet]]) }}
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-file-word" aria-hidden="true"></i> 下載 QR Code 列印用 Word 檔
            </button>
            {{ Form::close() }}
        </div>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
