@extends('layouts.app')

@section('title', '重設密碼')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>重設密碼</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email" class="col-md-2 col-form-label">信箱</label>

                            <div class="col-md-10">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                                       name="email"
                                       value="{{ $email or old('email') }}" required autofocus>

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
                                       class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="form-control-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <label for="password-confirm" class="col-md-2 col-form-label">確認密碼</label>
                            <div class="col-md-10">
                                <input id="password-confirm" type="password"
                                       class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                                       name="password_confirmation"
                                       required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="form-control-feedback">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    重設密碼
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
