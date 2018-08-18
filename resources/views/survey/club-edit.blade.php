@extends('layouts.base')

@section('title', '填寫平台問卷（擺攤社團填寫）')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/star-rating.css') }}" class="style">
@endsection

@section('buttons')
    @if($clubSurvey)
        <a href="{{ route('survey.club.show') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
        </a>
    @else
        <a href="{{ route('survey.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 問卷
        </a>
    @endif
@endsection

@section('main_content')
    <div class="alert alert-info">
        可於活動結束前（{{ new Carbon\Carbon(Setting::get('end_at')) }}）多次修改，結束後將無法填寫或修改
    </div>
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('survey.club.store', $clubSurvey), ['model' => $clubSurvey]) }}

            <div class="form-group row">
                <label class="col-md-2 col-form-label">使用者</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {{ $user->name }}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">社團</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {!! $user->club->display_name !!}
                    </p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">對於平台的滿意度</label>
                <div class="col-md-10">
                    <div class="starrating d-inline-flex justify-content-center flex-row-reverse">
                        @foreach(range(5,1) as $i)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                   @if(($clubSurvey->rating ?? null) == $i) checked @endif/><label
                                for="star{{ $i }}"></label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{ bs()->formGroup(bs()->textArea('comment')->attributes(['rows' => 10])->placeholder(''))->label('對於平台意見與建議')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
