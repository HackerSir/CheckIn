@extends('layouts.base')

@section('title', '條碼掃描')

@section('main_content')
    @if(isset($message))
        <div class="alert alert-{{ $level ?? 'info' }}" role="alert">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <h1>QR Code</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">條碼</dt>
                <dd class="col-md-10 code">{{ $code }}</dd>

                @if(isset($qrcode) && $qrcode->student)
                    <dt class="col-md-2">學生</dt>
                    <dd class="col-md-10">{{ $qrcode->student->masked_display_name }}</dd>
                @endif
            </dl>
            @if(isset($qrcode) && $qrcode->student)
                <hr/>

                <h1>抽獎活動</h1>
                @include('components.mission-info', ['student' => $qrcode->student])

                <hr/>

                <h1>打卡集點</h1>
                @include('components.check-in-progress', ['student' => $qrcode->student])
            @endif
        </div>
    </div>
@endsection
