@extends('layouts.base')

@section('title', $studentSurvey->student->name . '的學生問卷')

@section('css')
    <style>
        table tr td:first-child {
            white-space: nowrap
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('student-survey.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left mr-2"></i>學生問卷
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>學生資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-4">學號(NID)</dt>
                <dd class="col-md-8">{{ $studentSurvey->student->nid }}</dd>

                <dt class="col-md-4">姓名</dt>
                <dd class="col-md-8">
                    @if(Laratrust::can('student.manage'))
                        <a href="{{ route('student.show', $studentSurvey->student) }}">
                            {{ $studentSurvey->student->name }}
                        </a>
                    @else
                        {{ $studentSurvey->student->name }}
                    @endif
                </dd>

                <dt class="col-md-4">班級</dt>
                <dd class="col-md-8">{{ $studentSurvey->student->class }}</dd>

                <dt class="col-md-4">科系</dt>
                <dd class="col-md-8">{{ $studentSurvey->student->unit_name }}</dd>

                <dt class="col-md-4">學院</dt>
                <dd class="col-md-8">{{ $studentSurvey->student->dept_name }}</dd>

                <dt class="col-md-4">入學年度</dt>
                <dd class="col-md-8">{{ $studentSurvey->student->in_year }}</dd>

                <dt class="col-md-4">性別</dt>
                <dd class="col-md-8">{{ $studentSurvey->student->gender }}</dd>

                <dt class="col-md-4">新生</dt>
                <dd class="col-md-8">
                    @if($studentSurvey->student->is_freshman)
                        <i class="fa fa-check fa-2x text-success"></i>
                    @else
                        <i class="fa fa-times fa-2x text-danger"></i>
                    @endif
                </dd>
            </dl>

            <hr/>

            <h1>問卷</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-4">對於平台的滿意度</dt>
                <dd class="col-md-8">{{ $studentSurvey->stars }}</dd>

                <dt class="col-md-4">對於平台意見與建議</dt>
                <dd class="col-md-8">{!! nl2br(e($studentSurvey->comment)) !!}</dd>
            </dl>
        </div>
    </div>
@endsection
