@extends('layouts.base')

@section('title', '填寫回饋資料')

@section('buttons')
    <a href="{{ Url::previous() }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
@endsection

@section('main_content')
    <div class="alert alert-warning" role="alert">
        請注意：
        <ul style="padding-left: 20px">
            <li>每個社團只能填寫一次回饋資料，送出後無法修改或刪除</li>
            <li>
                送出回饋資料後，該社團可以取得您以下的資訊：
                <ul>
                    <li>學號</li>
                    <li>姓名</li>
                    <li>班級</li>
                    <li>科系</li>
                    <li>學院</li>
                    <li>入學年度</li>
                    <li>性別</li>
                </ul>
                以及您下方填寫的資料
                <ul>
                    <li>電話</li>
                    <li>信箱</li>
                    <li>給社團的意見</li>
                </ul>
            </li>
            <li>不同社團的回饋資料可以填寫不同地聯絡資訊</li>
            <li>系統會自動填入之前填寫的<strong>電話</strong>與<strong>信箱</strong>，可於送出前修改</li>
        </ul>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {{ bs()->openForm('post', route('feedback.store', $club)) }}

            <div class="form-group row">
                <label class="col-md-2 col-form-label">基本資料</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {{ $user->student->display_name }}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">社團</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {!! $club->display_name ?? '' !!}
                    </p>
                </div>
            </div>

            {{ bs()->formGroup(bs()->text('phone', $lastFeedback->phone ?? null))->label('電話')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('email', $lastFeedback->email ?? null))->label('信箱')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('message'))->label('給社團的意見')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('送出', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('form').on('submit', function () {
                return confirm('送出後將無法修改或刪除，確定要送出嗎？');
            });
        });
    </script>
@endsection
