@extends('layouts.app')

@section('title', '修改密碼')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('profile') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 個人資料
            </a>
            <h1>修改密碼</h1>
            <div class="card">
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('password.change') }}">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label for="password" class="col-md-2 col-form-label">密碼</label>

                            <div class="col-md-10">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}"
                                       name="password" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('new_password') ? ' has-danger' : '' }}">
                            <label for="new_password" class="col-md-2 col-form-label">新密碼</label>

                            <div class="col-md-10">
                                <input id="new_password" type="password"
                                       class="form-control{{ $errors->has('new_password') ? ' form-control-danger' : '' }}"
                                       name="new_password" required autofocus>

                                @if ($errors->has('new_password'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('new_password_confirmation') ? ' has-danger' : '' }}">
                            <label for="new_password_confirmation" class="col-md-2 col-form-label">確認新密碼</label>

                            <div class="col-md-10">
                                <input id="new_password_confirmation" type="password"
                                       class="form-control{{ $errors->has('new_password_confirmation') ? ' form-control-danger' : '' }}"
                                       name="new_password_confirmation" required autofocus>

                                @if ($errors->has('new_password_confirmation'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
