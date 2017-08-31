@extends('layouts.app')

@section('title', '新增回饋資料')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ Url::previous() }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
            </a>
            <h1>新增回饋資料</h1>
            <div class="card">
                <div class="card-block">
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
                <div class="card-block">
                    {{ Form::open(['route' => ['feedback.store', $club]]) }}

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">學生</label>
                        <div class="col-md-10">
                            <p class="form-control-static">
                                {{ $user->student->display_name }}
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">社團</label>
                        <div class="col-md-10">
                            <p class="form-control-static">
                                {!! $club->display_name ?? '' !!}
                            </p>
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('phone') ? ' has-danger' : '' }}">
                        <label for="phone" class="col-md-2 col-form-label">電話</label>
                        <div class="col-md-10">
                            {{ Form::text('phone', ($lastFeedback->phone ?? null), ['class' => 'form-control']) }}
                            @if ($errors->has('phone'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="col-md-2 col-form-label">信箱</label>
                        <div class="col-md-10">
                            {{ Form::email('email', ($lastFeedback->email ?? null), ['class' => 'form-control']) }}
                            @if ($errors->has('email'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('message') ? ' has-danger' : '' }}">
                        <label for="message" class="col-md-2 col-form-label">附加訊息</label>
                        <div class="col-md-10">
                            {{ Form::text('message', null, ['class' => 'form-control']) }}
                            @if ($errors->has('message'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check" aria-hidden="true"></i> 確認
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
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
