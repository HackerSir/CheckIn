@extends('layouts.base')

@section('title', '重設密碼')

@section('buttons')
    <a href="{{ route('login') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

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

                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-envelope" aria-hidden="true"></i> 發送重設密碼信件
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
