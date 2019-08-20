@extends('layouts.base')

@section('title', $qrcode->code . ' - QR Code')

@section('buttons')
    <a href="{{ route('qrcode.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left mr-2"></i>QR Code
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body text-center">
            <img src="{{ route('code-picture.qrcode', $qrcode->code) }}" class="img-fluid m-2"><br/>
            <img src="{{ route('code-picture.barcode', $qrcode->code) }}" class="img-fluid m-2">
        </div>
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-2">代號</dt>
                <dd class="col-8 col-md-10">
                    <span class="code">{{ $qrcode->code }}</span>
                    @if($qrcode->is_last_one)
                        <i class="fa fa-check text-success" title="最後一組"></i>
                    @endif
                </dd>
                <dt class="col-4 col-md-2">自動建立</dt>
                <dd class="col-8 col-md-10">
                    <span class="code">{{ $qrcode->auto_generated ? 'O' : 'X' }}</span>
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
@endsection
