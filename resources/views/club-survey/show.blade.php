@extends('layouts.base')

@section('title', $clubSurvey->user->name . '的社團問卷')

@section('css')
    <style>
        table tr td:first-child {
            white-space: nowrap
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('club-survey.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團問卷
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>使用者資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-2">使用者</dt>
                <dd class="col-8 col-md-10">
                    @if(Laratrust::can('user.manage'))
                        <a href="{{ route('user.show', $clubSurvey->user) }}">
                            {!! $clubSurvey->user->name !!}
                        </a>
                    @else
                        {{ $clubSurvey->user->name }}
                    @endif
                </dd>
                <dt class="col-4 col-md-2">社團</dt>
                <dd class="col-8 col-md-10">
                    @if(Laratrust::can('club.manage'))
                        <a href="{{ route('clubs.show', $clubSurvey->club) }}">
                            {!! $clubSurvey->club->display_name !!}
                        </a>
                    @else
                        {!! $clubSurvey->club->display_name !!}
                    @endif
                </dd>
            </dl>

            <hr/>

            <h1>問卷</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-2">星等評價</dt>
                <dd class="col-8 col-md-10">{{ $clubSurvey->stars }}</dd>

                <dt class="col-4 col-md-2">意見與建議</dt>
                <dd class="col-8 col-md-10">{!! nl2br(e($clubSurvey->comment)) !!}</dd>
            </dl>
        </div>
    </div>
@endsection
