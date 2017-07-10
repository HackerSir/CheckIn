@extends('layouts.app')

@section('title', '管理員註冊')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>管理員註冊</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-md-2 col-form-label">名稱</label>

                            <div class="col-md-10">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}"
                                       name="name"
                                       value="{{ old('name') }}" required
                                       autofocus>

                                @if ($errors->has('name'))
                                    <span class="form-control-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email" class="col-md-2 col-form-label">信箱</label>

                            <div class="col-md-10">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                                       name="email" value="{{ old('email') }}"
                                       required>

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
                            <label for="password-confirm" class="col-md-2 col-form-label">確認密碼</label>

                            <div class="col-md-10">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation"
                                       required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    註冊
                                </button>
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    登入
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
