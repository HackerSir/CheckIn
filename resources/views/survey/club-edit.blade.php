@extends('layouts.base')

@section('title', '填寫社團問卷')

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
        {{ new Carbon\Carbon(Setting::get('end_at')) }} 活動結束前可多次修改，結束後將無法填寫或修改
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

            <div class="alert alert-info">
                以下部分僅針對此平台，而非整個活動
            </div>

            {{ bs()->formGroup(bs()->radioGroup('rating', [
                1 => '★☆☆☆☆',
                2 => '★★☆☆☆',
                3 => '★★★☆☆',
                4 => '★★★★☆',
                5 => '★★★★★',
            ]))->label('星等評價')->showAsRow() }}
            {{ bs()->formGroup(bs()->textArea('comment')->attributes(['rows' => 10])->placeholder(''))->label('意見與建議')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
