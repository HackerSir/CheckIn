@extends('layouts.base')

@section('title', '給' . $feedback->club->name . '的回饋資料')

@section('css')
    <style>
        table tr td:first-child {
            white-space: nowrap
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('feedback.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 回饋資料
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>回饋資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">電話</dt>
                <dd class="col-md-10">
                    @if(is_null($feedback->phone) || $feedback->phone == '')
                        <span class="text-muted">(未填寫)</span>
                    @else
                        {{ $feedback->phone }}
                    @endif
                </dd>

                <dt class="col-md-2">信箱</dt>
                <dd class="col-md-10">
                    @if(is_null($feedback->email) || $feedback->email == '')
                        <span class="text-muted">(未填寫)</span>
                    @else
                        {{ $feedback->email }}
                    @endif
                </dd>

                <dt class="col-md-2">給社團的意見</dt>
                <dd class="col-md-10">
                    @if(is_null($feedback->message) || $feedback->message == '')
                        <span class="text-muted">(未填寫)</span>
                    @else
                        {{ $feedback->message }}
                    @endif
                </dd>
            </dl>

            <hr>

            <h1>基本資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">學號(NID)</dt>
                <dd class="col-md-10">{{ $feedback->student->nid }}</dd>

                <dt class="col-md-2">姓名</dt>
                <dd class="col-md-10">
                    @if(Laratrust::can('student.manage'))
                        <a href="{{ route('student.show', $feedback->student) }}">
                            {!! $feedback->student->name !!}
                        </a>
                    @else
                        {{ $feedback->student->name }}
                    @endif
                </dd>

                <dt class="col-md-2">班級</dt>
                <dd class="col-md-10">{{ $feedback->student->class }}</dd>

                <dt class="col-md-2">科系</dt>
                <dd class="col-md-10">{{ $feedback->student->unit_name }}</dd>

                <dt class="col-md-2">學院</dt>
                <dd class="col-md-10">{{ $feedback->student->dept_name }}</dd>

                <dt class="col-md-2">入學年度</dt>
                <dd class="col-md-10">{{ $feedback->student->in_year }}</dd>

                <dt class="col-md-2">性別</dt>
                <dd class="col-md-10">{{ $feedback->student->gender }}</dd>

                <dt class="col-md-2">新生</dt>
                <dd class="col-md-10">
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
                <dt class="col-md-2">社團</dt>
                <dd class="col-md-10">
                    <a href="{{ route('clubs.show', $feedback->club) }}">
                        {!! $feedback->club->display_name !!}
                    </a>
                </dd>

                <dt class="col-md-2">打卡時間</dt>
                <dd class="col-md-10">
                    @if($record)
                        {{ $record->created_at }}
                        （{{ $record->created_at->diffForHumans() }}）
                    @else
                        尚未打卡
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
