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
                    @php
                        $progress = ($student->countedRecords->count() / \Setting::get('target')) * 100;
                        $progress = round($progress, 2);
                    @endphp
                    @include('components.progress-bar', compact('progress'))

                    <hr/>

                    <h1>問卷</h1>
                    @if($student->studentSurvey)
                        <a href="{{ route('survey.student.show') }}" class="btn btn-primary btn-lg btn-block">
                            <i class="fa fa-search"></i> 檢視學生問卷
                        </a>
                    @else
                        @if($student->has_enough_counted_records)
                            <a href="{{ route('survey.student.edit') }}" class="btn btn-primary btn-lg btn-block">
                                <i class="fa fa-edit"></i> 填寫學生問卷
                            </a>
                        @else
                            <button type="button" class="btn btn-primary btn-lg btn-block disabled"
                                    onclick="alert('請先完成集點任務')">
                                <i class="fa fa-edit"></i> 填寫學生問卷
                            </button>
                        @endif
                    @endif

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

@section('js')
    <script src="{{ asset(mix('/build-js/checkin.js')) }}"></script>
@endsection
