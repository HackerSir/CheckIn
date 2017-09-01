@extends('layouts.app')

@section('title', '條碼掃描')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>條碼掃描</h1>
            @if(isset($message))
                <div class="alert alert-{{ $level ?? 'info' }}" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="card">
                <div class="card-block">
                    <h1>QR Code</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">條碼</dt>
                        <dd class="col-8 col-md-10">{{ $code }}</dd>

                        @if(isset($qrcode))
                            @if($qrcode->student)
                                <dt class="col-4 col-md-2">學生</dt>
                                <dd class="col-8 col-md-10">{{ $qrcode->student->masked_display_name }}</dd>
                            @endif
                        @endif
                    </dl>
                    @if(isset($qrcode) && $qrcode->student)
                        <hr/>

                        <h1>集點任務</h1>
                        <dl class="row" style="font-size: 120%">
                            <dt class="col-4 col-md-2">打卡次數</dt>
                            <dd class="col-8 col-md-10">{{ $qrcode->student->records->count() }}</dd>

                            <dt class="col-4 col-md-2">進度</dt>
                            <dd class="col-8 col-md-10">{{ $qrcode->student->countedRecords->count() }}
                                / {{ \Setting::get('target') }}</dd>
                        </dl>
                        <div class="progress w-80">
                            @php
                                $progress = ($qrcode->student->countedRecords->count() / \Setting::get('target')) * 100;
                                $progress = round($progress, 2);
                            @endphp
                            <div class="progress-bar d-flex align-items-center justify-content-center"
                                 role="progressbar"
                                 style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                 aria-valuemax="100">
                                <div>{{ $progress }}%</div>
                            </div>
                        </div>

                        <hr/>

                        <h1>抽獎編號</h1>
                        <div class="text-center">
                            @if(isset($qrcode->student->ticket))
                                <h3 class="text-danger">{{ sprintf("%04d", $qrcode->student->ticket->id) }}</h3>
                            @else
                                @if(!$qrcode->student->is_freshman)
                                    <p class="text-danger">
                                        未具備抽獎資格，即使完成任務，也無法參加抽獎（抽獎活動限新生參加）
                                    </p>
                                @else
                                    <h3 class="text-danger">集點任務尚未完成</h3>
                                @endif
                            @endif
                        </div>

                        <hr/>

                        <h1>打卡紀錄</h1>
                        @include('components.record-list', ['records' => $qrcode->student->records])
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
