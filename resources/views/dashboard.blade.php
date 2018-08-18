@extends('layouts.app')

@section('title', $student->name)

@section('css')
    <style>
        .badge {
            font-size: 75% !important;
        }
    </style>
@endsection

@section('content')
    <div class="mt-3 pb-3">
        <div class="mt-1 mb-3">
            <div class="card">
                <div class="card-body">
                    <h1>QR Code</h1>
                    <div class="text-center">
                        @if($student->qrcode)
                            <p class="text-danger">請在攤位出示此 QR Code 來進行打卡</p>
                            <img src="{{ route('code-picture.qrcode', $student->qrcode->code) }}" class="img-fluid">
                        @else
                            <div class="alert alert-danger" role="alert">
                                o_O 沒有 QR Code？<br/>
                                請嘗試重新登入，讓系統產生新的 QR Code
                            </div>
                        @endif
                        <p class="mt-1">集點時間：<span style="white-space: pre;">{{ $startAt }}</span> ~ <span style="white-space: pre;">{{ $endAt }}</span></p>
                    </div>

                    <hr/>

                    <h1>抽獎活動</h1>
                    @if(isset($student->ticket))
                        <div class="alert alert-success">
                            <i class="fas fa-ticket-alt"></i> 抽獎編號 <i class="fas fa-ticket-alt"></i>
                            <h3>{{ sprintf("%04d", $student->ticket->id) }}</h3>
                        </div>
                    @else
                        @if(!$student->is_freshman)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 抽獎活動限<strong>大學部新生參加</strong>，即使完成任務，也無法參加抽獎
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> 完成以下任務，即可取得抽獎編號
                            </div>
                        @endif
                    @endif
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-md-2">打卡集點</dt>
                        <dd class="col-md-10">
                            @if($student->has_enough_counted_records)
                                <span class="text-success">
                                    <i class="far fa-check-square"></i> 已完成
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="far fa-square"></i> 未完成
                                </span>
                                <span>（{{ $student->countedRecords->count() }} / {{ \Setting::get('target') }}）</span>
                            @endif
                        </dd>
                        <dt class="col-md-2">填寫平台問卷</dt>
                        <dd class="col-md-10">
                            <div class="mb-2">
                                @if($student->studentSurvey)
                                    <span class="text-success">
                                        <i class="far fa-check-square"></i> 已完成
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="far fa-square"></i> 未完成
                                    </span>
                                @endif
                            </div>
                            @if($student->studentSurvey)
                                <a href="{{ route('survey.student.show') }}" class="btn btn-success">
                                    <i class="fa fa-search"></i> 檢視平台問卷
                                </a>
                            @elseif(Carbon\Carbon::now()->gt(new Carbon\Carbon(Setting::get('end_at'))))
                                <button type="button" class="btn btn-primary disabled"
                                        onclick="alert('已超過填寫時間')">
                                    <i class="fa fa-edit"></i> 填寫平台問卷
                                </button>
                            @elseif(!$student->has_enough_counted_records)
                                <button type="button" class="btn btn-primary disabled"
                                        onclick="alert('請先完成集點任務')">
                                    <i class="fa fa-edit"></i> 填寫平台問卷
                                </button>
                            @else
                                <a href="{{ route('survey.student.edit') }}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i> 填寫平台問卷
                                </a>
                            @endif
                        </dd>
                    </dl>

                    <hr/>

                    <h1>打卡集點</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-md-2">打卡次數</dt>
                        <dd class="col-md-10">{{ $student->records->count() }}</dd>

                        <dt class="col-md-2">進度</dt>
                        <dd class="col-md-10">{{ $student->countedRecords->count() }}
                            / {{ \Setting::get('target') }}</dd>
                    </dl>
                    @php
                        $progress = ($student->countedRecords->count() / \Setting::get('target')) * 100;
                        $progress = round($progress, 2);
                    @endphp
                    @include('components.progress-bar', compact('progress'))

                    <hr/>

                    <h1>打卡紀錄</h1>
                    @include('components.record-list', ['student' => $student, 'showFeedbackButton' => true])

                    <hr/>

                    <h1>個人資料</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-md-2">學號</dt>
                        <dd class="col-md-10">{{ $student->nid }}</dd>

                        <dt class="col-md-2">姓名</dt>
                        <dd class="col-md-10">{{ $student->name }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset(mix('/build-js/checkin.js')) }}"></script>
@endsection
