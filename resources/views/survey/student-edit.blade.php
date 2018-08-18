@extends('layouts.base')

@section('title', '平台問卷')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/star-rating.css') }}" class="style">
@endsection

@section('buttons')
    @if($studentSurvey)
        <a href="{{ route('survey.student.show') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
        </a>
    @else
        <a href="{{ route('survey.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
        </a>
    @endif
@endsection

@section('main_content')
    <div class="alert alert-info">
        <ul style="padding-left: 20px">
            <li>可於活動結束前（{{ new Carbon\Carbon(Setting::get('end_at')) }}）多次修改，結束後將無法填寫或修改</li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('survey.student.store', $studentSurvey), ['model' => $studentSurvey]) }}

            <div class="form-group row">
                <label class="col-md-2 col-form-label">基本資料</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {{ $user->student->display_name }}
                    </p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">對於平台的滿意度</label>
                <div class="col-md-10">
                    <div class="starrating d-inline-flex justify-content-center flex-row-reverse">
                        @foreach(range(5,1) as $i)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                   @if(($studentSurvey->rating ?? null) == $i) checked @endif/><label
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
