@extends('layouts.app')

@section('title', '重設密碼')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>重設密碼</h1>
            <div class="card">
                <div class="card-block">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email" class="col-md-2 form-control-label">信箱</label>

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
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    發送密碼重設連結
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
