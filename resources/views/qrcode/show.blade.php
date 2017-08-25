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
                    <img src="{{ route('code-picture.qrcode', $qrcode->code) }}" class="img-fluid">
                    <br/>
                    <br/>
                    <img src="{{ route('code-picture.barcode', $qrcode->code) }}" class="img-fluid">
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">代號：</td>
                            <td>
                                {{ $qrcode->code }}
                                @if($qrcode->is_last_one)
                                    <i class="fa fa-check text-success" aria-hidden="true" title="最後一組"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">學生：</td>
                            <td>
                                @if($qrcode->student)
                                    @if(Laratrust::can('student.manage'))
                                        {{ link_to_route('student.show', $qrcode->student->display_name, $qrcode->student) }}
                                    @else
                                        {{ $qrcode->student->display_name }}
                                    @endif
                                @else
                                    尚未綁定
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">綁定時間：</td>
                            <td>
                                @if($qrcode->bind_at)
                                    {{ $qrcode->bind_at }}
                                    （{{ $qrcode->bind_at->diffForHumans() }}）
                                @else
                                    尚未綁定
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
