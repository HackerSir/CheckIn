@extends('layouts.app')

@section('title', '給' . $feedback->club->name . '的回饋資料')

@section('css')
    <style>
        table tr td:first-child {
            white-space: nowrap
        }
    </style>
@endsection

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('feedback.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 回饋資料
            </a>
            <h1>給{{ $feedback->club->name }}的回饋資料</h1>
            <div class="card">
                <div class="card-block">
                    <h1>學生資料</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">學號(NID)</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->student->nid }}</dd>

                        <dt class="col-4 col-md-2">姓名</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->student->name }}</dd>

                        <dt class="col-4 col-md-2">班級</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->student->class }}</dd>

                        <dt class="col-4 col-md-2">科系</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->student->unit_name }}</dd>

                        <dt class="col-4 col-md-2">學院</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->student->dept_name }}</dd>

                        <dt class="col-4 col-md-2">入學年度</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->student->in_year }}</dd>

                        <dt class="col-4 col-md-2">性別</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->student->gender }}</dd>

                        <dt class="col-4 col-md-2">新生</dt>
                        <dd class="col-8 col-md-10">
                            @if($feedback->student->is_freshman)
                                <i class="fa fa-check fa-2x text-success" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-times fa-2x text-danger" aria-hidden="true"></i>
                            @endif
                        </dd>
                    </dl>

                    <hr/>

                    <h1>社團資料</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">社團</dt>
                        <dd class="col-8 col-md-10">
                            {!! $feedback->club->clubType->tag ?? '' !!}
                            {{ $feedback->club->name }}
                        </dd>

                        <dt class="col-4 col-md-2">打卡時間</dt>
                        <dd class="col-8 col-md-10">
                            @if($record)
                                <i class="fa fa-check fa-fw fa-2x text-success" aria-hidden="true"></i>
                                {{ $record->created_at }}
                                （{{ $record->created_at->diffForHumans() }}）
                            @else
                                <i class="fa fa-times fa-fw fa-2x text-danger" aria-hidden="true"></i>
                                尚未打卡
                            @endif
                        </dd>
                    </dl>

                    <hr/>

                    <h1>回饋資料</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">電話</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->phone }}</dd>

                        <dt class="col-4 col-md-2">信箱</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->email }}</dd>

                        <dt class="col-4 col-md-2">訊息</dt>
                        <dd class="col-8 col-md-10">{{ $feedback->message }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
