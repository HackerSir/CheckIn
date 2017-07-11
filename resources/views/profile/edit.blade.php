@extends('layouts.app')

@section('title', '編輯個人資料')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>編輯個人資料</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('profile.update') }}">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">信箱</label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control" value="{{ $user->email }}" readonly>
                                <small class="form-text text-muted">信箱作為帳號使用，故無法修改</small>
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-md-2 col-form-label">名稱</label>

                            <div class="col-md-10">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}"
                                       name="name"
                                       value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="form-control-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary"> 更新個人資料</button>
                                <a href="{{ route('profile') }}" class="btn btn-secondary">返回個人資料</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
