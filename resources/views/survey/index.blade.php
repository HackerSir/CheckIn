@extends('layouts.base')

@section('title', '問卷')

@section('main_content')
    <div class="alert alert-info">
        {{ new Carbon\Carbon(Setting::get('end_at')) }} 活動結束前可多次修改，結束後將無法填寫或修改
    </div>
    <div class="card">
        <div class="card-body">
            @if($user->student)
                <a href="{{ route('survey.student.show') }}" class="btn btn-primary btn-lg btn-block">學生問卷</a>
            @else
                <button type="button" class="btn btn-secondary btn-lg btn-block disabled">學生問卷（限學生填寫）</button>
            @endif
            @if($user->club)
                {{-- TODO: 修改網址 --}}
                <a href="{{ route('survey.student.show') }}" class="btn btn-primary btn-lg btn-block">攤位問卷</a>
            @else
                <button type="button" class="btn btn-secondary btn-lg btn-block disabled">攤位問卷（限擺攤社團填寫）</button>
            @endif
        </div>
    </div>
@endsection
