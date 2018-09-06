@extends('layouts.base')

@section('title', '平台問卷')

@section('css')
    <style>
        table tr td:first-child {
            white-space: nowrap
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('survey.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 問卷
    </a>
    @if(\Carbon\Carbon::now()->lte(new Carbon\Carbon(Setting::get('end_at'))))
        <a href="{{ route('survey.student.edit') }}" class="btn btn-primary">
            <i class="fa fa-edit" aria-hidden="true"></i> 編輯
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-4">基本資料</dt>
                <dd class="col-md-8">
                    @if(Laratrust::can('student.manage'))
                        <a href="{{ route('student.show', $studentSurvey->student) }}">
                            {{ $studentSurvey->student->display_name }}
                        </a>
                    @else
                        {{ $studentSurvey->student->display_name }}
                    @endif
                </dd>
            </dl>
            <hr/>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-4">對於平台的滿意度</dt>
                <dd class="col-md-8">{{ $studentSurvey->stars }}</dd>

                <dt class="col-md-4">對於平台意見與建議</dt>
                <dd class="col-md-8">{!! nl2br(e($studentSurvey->comment)) !!}</dd>
            </dl>
        </div>
    </div>
@endsection
