@extends('layouts.app')

@section('title', '編輯個人資料')

@section('content')
    <div class="card">
        <div class="card-header">
            編輯個人資料
        </div>
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('profile.update') }}">
                {{ csrf_field() }}
                {{ method_field('put') }}

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label">信箱</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" value="{{ $user->email }}" readonly>
                        <span class="form-text">信箱作為帳號使用，故無法修改</span>
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="name" class="col-md-4 col-form-label">名稱</label>

                    <div class="col-md-6">
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
                    <div class="col-md-8 offset-md-4">
                        <a href="{{ route('profile') }}" class="btn btn-secondary">返回個人資料</a>
                        <button type="submit" class="btn btn-primary"> 更新個人資料</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
