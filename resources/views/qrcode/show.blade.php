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
                    <img src="{{ route('code-picture.qrcode', $qrcode->code) }}" class="img-fluid m-2">
                    <img src="{{ route('code-picture.barcode', $qrcode->code) }}" class="img-fluid m-2">
                </div>
                <div class="card-block">
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">代號</dt>
                        <dd class="col-8 col-md-10">
                            <span class="code">{{ $qrcode->code }}</span>
                            @if($qrcode->is_last_one)
                                <i class="fa fa-check text-success" aria-hidden="true" title="最後一組"></i>
                            @endif
                        </dd>

                        <dt class="col-4 col-md-2">學生</dt>
                        <dd class="col-8 col-md-10">
                            @if($qrcode->student)
                                @if(Laratrust::can('student.manage'))
                                    {{ link_to_route('student.show', $qrcode->student->display_name, $qrcode->student) }}
                                @else
                                    {{ $qrcode->student->display_name }}
                                @endif
                            @else
                                尚未綁定
                            @endif
                        </dd>

                        <dt class="col-4 col-md-2">綁定時間</dt>
                        <dd class="col-8 col-md-10">
                            @if($qrcode->bind_at)
                                {{ $qrcode->bind_at }}
                                （{{ $qrcode->bind_at->diffForHumans() }}）
                            @else
                                尚未綁定
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
