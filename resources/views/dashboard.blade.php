@extends('layouts.app')

@section('title', $student->name . ' - 學生')

@section('css')
    <style>
        .badge {
            font-size: 75% !important;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-block">
                    <h1>QR Code</h1>
                    <div class="text-center">
                        @if($student->qrcode)
                            <p class="text-warning">請在攤位出示此 QR Code 來進行打卡</p>
                            <img src="{{ route('code-picture.qrcode', $student->qrcode->code) }}" class="img-fluid">
                        @else
                            <div class="alert alert-danger" role="alert">
                                o_O 沒有 QR Code？<br/>
                                請嘗試重新登入，讓系統產生新的 QR Code
                            </div>
                        @endif
                        <p class="mt-1">集點時間：<span>{{ $startAt }}</span> ~ <span>{{ $endAt }}</span></p>
                    </div>

                    <hr/>

                    <h1>集點任務</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">打卡次數</dt>
                        <dd class="col-8 col-md-10">{{ $student->records->count() }}</dd>

                        <dt class="col-4 col-md-2">進度</dt>
                        <dd class="col-8 col-md-10">{{ $student->countedRecords->count() }}
                            / {{ \Setting::get('target') }}</dd>
                    </dl>
                    <div class="progress w-80">
                        @php
                            $progress = ($student->countedRecords->count() / \Setting::get('target')) * 100;
                            $progress = round($progress, 2);
                        @endphp
                        <div class="progress-bar d-flex align-items-center justify-content-center" role="progressbar"
                             style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0"
                             aria-valuemax="100">
                            <div>{{ $progress }}%</div>
                        </div>
                    </div>

                    <hr/>

                    <h1>抽獎編號</h1>
                    <div class="text-center">
                        @if(isset($student->ticket))
                            <h3 class="text-danger">{{ sprintf("%04d", $student->ticket->id) }}</h3>
                        @else
                            @if(!$student->is_freshman)
                                <p class="text-danger">
                                    未具備抽獎資格，即使完成任務，也無法參加抽獎（抽獎活動限大學部新生參加）
                                </p>
                            @else
                                <h3 class="text-danger">集點任務尚未完成</h3>
                            @endif
                        @endif
                    </div>

                    <hr/>

                    <h1>打卡紀錄</h1>
                    @include('components.record-list', ['records' => $student->records])

                    <hr/>

                    <h1>個人資料</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">學號</dt>
                        <dd class="col-8 col-md-10">{{ $student->nid }}</dd>

                        <dt class="col-4 col-md-2">姓名</dt>
                        <dd class="col-8 col-md-10">{{ $student->name }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
