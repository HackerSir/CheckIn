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
    @php($user = auth()->user())
    @if(optional($user)->student)
        <a href="{{ route('my-qrcode') }}" class="btn btn-secondary mb-2">
            <i class="fa fa-arrow-left mr-2"></i>QR Code
        </a>
        <a href="{{ route('feedback.my') }}" class="btn btn-secondary mb-2">
            <i class="fa fa-arrow-left mr-2"></i>我的回饋資料
        </a>
    @endif
    @if(Laratrust::isAbleTo('feedback.manage') || optional($user)->club)
        <a href="{{ route('feedback.index') }}" class="btn btn-secondary mb-2">
            <i class="fa fa-arrow-left mr-2"></i>回饋資料管理
        </a>
    @endif
    @if(($user->student->nid ?? null) == $feedback->student->nid)
        <a href="{{ route('feedback.create', $feedback->club) }}" class="btn btn-primary mb-2">
            <i class="fa fa-edit mr-2"></i>編輯
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>回饋資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">電話</dt>
                <dd class="col-md-10">
                    @if(!$feedback->phone)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $feedback->phone }}
                    @endif
                </dd>

                <dt class="col-md-2">信箱</dt>
                <dd class="col-md-10">
                    @if(!$feedback->email)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $feedback->email }}
                    @endif
                </dd>

                <dt class="col-md-2">Facebook</dt>
                <dd class="col-md-10">
                    @if(!$feedback->facebook)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $feedback->facebook }}
                    @endif
                </dd>

                <dt class="col-md-2">LINE ID</dt>
                <dd class="col-md-10">
                    @if(!$feedback->line)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $feedback->line }}
                    @endif
                </dd>

                <dt class="col-md-2">給社團的意見</dt>
                <dd class="col-md-10">
                    @if(!$feedback->message)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $feedback->message }}
                    @endif
                </dd>

                <dt class="col-md-2">社團提問</dt>
                <dd class="col-md-10">
                    @if(!$feedback->custom_question)
                        <span class="text-muted">（無）</span>
                    @else
                        <span class="badge badge-secondary">提問</span>
                        {{ $feedback->custom_question }}<br/>
                        <span class="badge badge-secondary">回答</span>
                        @if(!$feedback->answer_of_custom_question)
                            <span class="text-muted">（未填寫）</span>
                        @else
                            {{ $feedback->answer_of_custom_question }}
                        @endif
                    @endif
                </dd>

                <dt class="col-md-2">加入社團意願</dt>
                <dd class="col-md-10">
                   {{ \App\Models\Feedback::$intentionText[$feedback->join_club_intention] ?? null }}
                </dd>

                <dt class="col-md-2">參與迎新茶會意願</dt>
                <dd class="col-md-10">
                    {{ \App\Models\Feedback::$intentionText[$feedback->join_tea_party_intention] ?? null }}
                </dd>
            </dl>

            <hr>

            <h1>基本資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">學號(NID)</dt>
                <dd class="col-md-10">{{ $feedback->student->nid }}</dd>

                <dt class="col-md-2">姓名</dt>
                <dd class="col-md-10">
                    @if(Laratrust::isAbleTo('student.manage'))
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
                        <i class="fa fa-check fa-2x text-success"></i>
                    @else
                        <i class="fa fa-times fa-2x text-danger"></i>
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
