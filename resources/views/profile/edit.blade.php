@extends('layouts.base')

@section('title', '編輯個人資料')

@section('buttons')
    <a href="{{ route('profile') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 個人資料
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
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
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check" aria-hidden="true"></i> 確認
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
