@extends('layouts.base')

@section('title', '兩步驟驗證')

@section('content')
    <div class="card">
        <div class="card-body">
            <form role="form" method="POST" action="{{ route('login.2fa') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('one_time_password') ? ' has-danger' : '' }}">
                    <label for="one_time_password" class="col-md-4 col-form-label">驗證碼</label>

                    <div class="col-md-6">
                        <input id="one_time_password" type="text"
                               class="form-control{{ $errors->has('one_time_password') ? ' form-control-danger' : '' }}"
                               name="one_time_password" required autofocus>
                        <span class="form-text">請輸入 <a
                                href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                                target="_blank">Google Authenticator</a> 顯示之驗證碼</span>

                        @if ($errors->has('one_time_password'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('one_time_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check" aria-hidden="true"></i> 確認
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
