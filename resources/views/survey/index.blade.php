@extends('layouts.base')

@section('title', '平台問卷')

@section('main_content')
    <div class="alert alert-info">
        可於活動結束前（{{ new Carbon\Carbon(Setting::get('end_at')) }}）多次修改，結束後將無法填寫或修改
    </div>
    <div class="card">
        <div class="card-body">
            @if($user->student)
                <a href="{{ route('survey.student.show') }}" class="btn btn-primary btn-lg btn-block">學生問卷</a>
            @else
                <button type="button" class="btn btn-secondary btn-lg btn-block disabled">學生問卷（限學生填寫）</button>
            @endif
            @if($user->club)
                <a href="{{ route('survey.club.show') }}" class="btn btn-primary btn-lg btn-block">社團問卷</a>
            @else
                <button type="button" class="btn btn-secondary btn-lg btn-block disabled">社團問卷（限擺攤社團填寫）</button>
            @endif
        </div>
    </div>
@endsection
