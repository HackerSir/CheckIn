@extends('layouts.app')

@section('title', '管理員登入')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>管理員登入</h1>
            <div class="card">
                <div class="card-block">
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
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">記住我</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    登入
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
        </div>
    </div>
@endsection
