@extends('layouts.app')

@section('title', $qrcodeSet->id . ' - QR Code 集')

@section('content')
    <div class="mt-3 pb-3">
        <a href="{{ route('qrcode-set.index') }}" class="btn btn-secondary mb-2">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code 集
        </a>
        <h1>{{ $qrcodeSet->id }} - QR Code 集</h1>
        <div class="card">
            <div class="card-block">
                <table class="table table-hover">
                    <tr>
                        <td class="text-md-right">編號：</td>
                        <td>{{ $qrcodeSet->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-md-right">數量：</td>
                        <td>{{ $qrcodeSet->qrcodes()->count() }}</td>
                    </tr>
                    <tr>
                        <td class="text-md-right">建立時間：</td>
                        <td>{{ $qrcodeSet->created_at }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-block text-center">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="alert('Coming soon...')">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> 下載 QR Code 列印用 PDF
                </a>
            </div>
        </div>
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
