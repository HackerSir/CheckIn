@extends('layouts.base')

@section('title', '平台問卷')

@section('main_content')
    <div class="alert alert-info">
        可於指定期限內多次修改，結束後將無法填寫或修改<br/>
        學生問卷：活動結束（{{ $endAt }}）之前<br/>
        社團問卷：回饋資料填寫期限（{{ $feedbackCreateExpiredAt }}）之前
    </div>
    <div class="card">
        <div class="card-body">
            @if($user->student)
                @if($user->student->studentSurvey || \Carbon\Carbon::now()->lte($endAt))
                    <a href="{{ route('survey.student.show') }}" class="btn btn-primary btn-lg btn-block">學生問卷</a>
                @else
                    <button type="button" class="btn btn-secondary btn-lg btn-block disabled">學生問卷（已超過填寫期限）</button>
                @endif
            @else
                <button type="button" class="btn btn-secondary btn-lg btn-block disabled">學生問卷（限學生填寫）</button>
            @endif
            @if($user->club)
                @if($user->clubSurvey || \Carbon\Carbon::now()->lte($feedbackCreateExpiredAt))
                    <a href="{{ route('survey.club.show') }}" class="btn btn-primary btn-lg btn-block">社團問卷</a>
                @else
                    <button type="button" class="btn btn-secondary btn-lg btn-block disabled">社團問卷（已超過填寫期限）</button>
                @endif

            @else
                <button type="button" class="btn btn-secondary btn-lg btn-block disabled">社團問卷（限擺攤社團填寫）</button>
            @endif
        </div>
    </div>
@endsection
