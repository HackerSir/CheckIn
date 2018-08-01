@extends('layouts.base')

@section('title', '管理員登入')

@section('main_content')
    <div class="card">
        <div class="card-body">
            <div class="alert alert-warning" role="alert">
                <strong>警告！</strong>學生請使用<a href="{{ route('oauth.index') }}" class="alert-link">NID登入</a>
            </div>
            <form role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label for="email" class="col-md-2 col-form-label">信箱</label>

                    <div class="col-md-10">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                               name="email"
                               value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password" class="col-md-2 col-form-label">密碼</label>

                    <div class="col-md-10">
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}"
                               name="password" required>

                        @if ($errors->has('password'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-10 offset-md-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="remember" name="remember" class="custom-control-input">
                            <label class="custom-control-label" for="remember">
                                記住我
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check" aria-hidden="true"></i> 登入
                        </button>

                        <a class="btn btn-link" href="{{ route('register') }}">
                            註冊
                        </a>
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            忘記密碼
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
