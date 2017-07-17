@extends('layouts.app')

@section('title', $qrcode->code . ' - QR Code')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('qrcode.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code
            </a>
            <h1>{{ $qrcode->code }} - QR Code</h1>
            <div class="card">
                <div class="card-block text-center">
                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($qrcode->scan_url, "QRCODE", 12, 12) }}">
                    <br/>
                    <br/>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($qrcode->code, 'C128B', 3, 90) }}">
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">代號：</td>
                            <td>{{ $qrcode->code }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">學生：</td>
                            <td>{{ $qrcode->student->display_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">綁定時間：</td>
                            <td>{{ $qrcode->bind_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
