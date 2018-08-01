@extends('layouts.base')

@section('title', '重設密碼')

@section('main_content')
    <div class="card">
        <div class="card-body">
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
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check" aria-hidden="true"></i> 重設密碼
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
