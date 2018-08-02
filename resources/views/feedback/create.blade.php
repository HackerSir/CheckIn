@extends('layouts.base')

@section('title', '新增回饋資料')

@section('buttons')
    <a href="{{ Url::previous() }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            請注意：
            <ul>
                <li>僅能於每個社團填寫一次</li>
                <li>填寫後，無法修改或刪除</li>
                <li>填寫後，該社團將取得您的<code>學號</code>、<code>姓名</code>、<code>班級</code>、<code>科系</code>、<code>學院</code>、<code>入學年度</code>、<code>性別</code>，
                    以及您所填寫的<code>電話</code>、<code>信箱</code>、<code>訊息</code></li>
                <li>在不同社團，可填寫不同聯絡資訊</li>
                <li><code>電話</code>與<code>信箱</code>將預先填入上次所填之內容，可於送出前修改</li>
            </ul>
        </div>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {{ bs()->openForm('post', route('feedback.store', $club)) }}

            <div class="form-group row">
                <label class="col-md-2 col-form-label">學生</label>
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
            {{ bs()->formGroup(bs()->text('message'))->label('附加訊息')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
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
