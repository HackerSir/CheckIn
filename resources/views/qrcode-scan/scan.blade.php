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
                <dt class="col-4 col-md-2">條碼</dt>
                <dd class="col-8 col-md-10 code">{{ $code }}</dd>

                @if(isset($qrcode))
                    @if($qrcode->student)
                        <dt class="col-4 col-md-2">學生</dt>
                        <dd class="col-8 col-md-10">{{ $qrcode->student->masked_display_name }}</dd>
                    @endif
                @endif
            </dl>
            @if(isset($qrcode) && $qrcode->student)
                <hr/>

                <h1>抽獎活動</h1>
                <div class="text-center">
                    @if(isset($qrcode->student->ticket))
                        <div class="alert alert-success">
                            <i class="fas fa-ticket-alt"></i> 抽獎編號 <i class="fas fa-ticket-alt"></i>
                            <h3>{{ sprintf("%04d", $qrcode->student->ticket->id) }}</h3>
                        </div>
                    @else
                        @if(!$qrcode->student->is_freshman)
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> 未具備抽獎資格，即使完成任務，也無法參加抽獎（抽獎活動限大學部新生參加）
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> 完成以下任務，即可取得抽獎編號
                            </div>
                        @endif
                    @endif
                </div>
                <dl class="row" style="font-size: 120%">
                    <dt class="col-4 col-md-2">打卡集點</dt>
                    <dd class="col-8 col-md-10">
                        @if($qrcode->student->has_enough_counted_records)
                            <span class="text-success">
                                <i class="far fa-check-square"></i> 已完成
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="far fa-square"></i> 未完成
                            </span>
                            <span>（{{ $qrcode->student->countedRecords->count() }} / {{ \Setting::get('target') }}
                                ）</span>
                        @endif
                    </dd>
                    <dt class="col-4 col-md-2">填寫問卷</dt>
                    <dd class="col-8 col-md-10">
                        @if($qrcode->student->studentSurvey)
                            <span class="text-success">
                                <i class="far fa-check-square"></i> 已完成
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="far fa-square"></i> 未完成
                            </span>
                        @endif
                    </dd>
                </dl>

                <hr/>

                <h1>打卡集點</h1>
                <dl class="row" style="font-size: 120%">
                    <dt class="col-4 col-md-2">打卡次數</dt>
                    <dd class="col-8 col-md-10">{{ $qrcode->student->records->count() }}</dd>

                    <dt class="col-4 col-md-2">進度</dt>
                    <dd class="col-8 col-md-10">{{ $qrcode->student->countedRecords->count() }}
                        / {{ \Setting::get('target') }}</dd>
                </dl>
                @php
                    $progress = ($qrcode->student->countedRecords->count() / \Setting::get('target')) * 100;
                    $progress = round($progress, 2);
                @endphp
                @include('components.progress-bar', compact('progress'))

                <hr/>

                <h1>打卡紀錄</h1>
                @include('components.record-list', ['records' => $qrcode->student->records])
            @endif
        </div>
    </div>
@endsection
