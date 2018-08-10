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
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生問卷
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>學生資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-2">學號(NID)</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->student->nid }}</dd>

                <dt class="col-4 col-md-2">姓名</dt>
                <dd class="col-8 col-md-10">
                    @if(Laratrust::can('student.manage'))
                        <a href="{{ route('student.show', $studentSurvey->student) }}">
                            {!! $studentSurvey->student->name !!}
                        </a>
                    @else
                        {{ $studentSurvey->student->name }}
                    @endif
                </dd>

                <dt class="col-4 col-md-2">班級</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->student->class }}</dd>

                <dt class="col-4 col-md-2">科系</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->student->unit_name }}</dd>

                <dt class="col-4 col-md-2">學院</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->student->dept_name }}</dd>

                <dt class="col-4 col-md-2">入學年度</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->student->in_year }}</dd>

                <dt class="col-4 col-md-2">性別</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->student->gender }}</dd>

                <dt class="col-4 col-md-2">新生</dt>
                <dd class="col-8 col-md-10">
                    @if($studentSurvey->student->is_freshman)
                        <i class="fa fa-check fa-2x text-success" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-times fa-2x text-danger" aria-hidden="true"></i>
                    @endif
                </dd>
            </dl>

            <hr/>

            <h1>問卷</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-2">星等評價</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->rating }}</dd>

                <dt class="col-4 col-md-2">意見與建議</dt>
                <dd class="col-8 col-md-10">{{ $studentSurvey->comment }}</dd>
            </dl>
        </div>
    </div>
@endsection
