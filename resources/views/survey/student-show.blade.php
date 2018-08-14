@extends('layouts.base')

@section('title', '學生問卷')

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
    <a href="{{ route('survey.student.edit') }}" class="btn btn-primary">
        <i class="fa fa-edit" aria-hidden="true"></i> 編輯
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-sm-4 col-md-2">學生</dt>
                <dd class="col-sm-8 col-md-10">
                    @if(Laratrust::can('student.manage'))
                        <a href="{{ route('student.show', $studentSurvey->student) }}">
                            {!! $studentSurvey->student->display_name !!}
                        </a>
                    @else
                        {{ $studentSurvey->student->display_name }}
                    @endif
                </dd>
            </dl>
            <hr/>
            <dl class="row" style="font-size: 120%">
                <dt class="col-sm-4 col-md-2">星等評價</dt>
                <dd class="col-sm-8 col-md-10">{{ $studentSurvey->stars }}</dd>

                <dt class="col-sm-4 col-md-2">意見與建議</dt>
                <dd class="col-sm-8 col-md-10">{!! nl2br(e($studentSurvey->comment)) !!}</dd>
            </dl>
        </div>
    </div>
@endsection