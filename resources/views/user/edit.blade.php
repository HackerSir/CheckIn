@extends('layouts.app')

@section('title', "{$user->name} - 編輯會員資料")

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $user->name }} - 編輯會員資料
        </div>
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('user.update', $user) }}">
                {{ csrf_field() }}
                {{ method_field('patch') }}

                <div class="form-group row">
                    <label for="email" class="col-md-4 form-control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" value="{{ $user->email }}" readonly>
                        <span class="form-text">信箱作為帳號使用，故無法修改</span>
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="name" class="col-md-4 form-control-label">Name</label>

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

                <div class="form-group row{{ $errors->has('role') ? ' has-danger' : '' }}">
                    <label class="col-md-4 form-control-label">角色</label>
                    <div class="col-md-6">
                        @foreach($roles as $role)
                            @if($user->id == Auth::user()->id && $role->name == 'Admin')
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="role[]" value="{{ $role->id }}"
                                           class="custom-control-input" @if($user->hasRole($role->name))
                                           checked disabled @endif>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">
                                        {{ $role->display_name }}（{{ $role->description }}）
                                        <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"
                                           title="禁止解除自己的管理員職務"></i>
                                    </span>
                                </label>
                            @else
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="role[]" value="{{ $role->id }}"
                                           class="custom-control-input" @if($user->hasRole($role->name)) checked @endif>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">
                                        {{ $role->display_name }}（{{ $role->description }}）
                                    </span>
                                </label>
                            @endif
                            <br/>
                        @endforeach
                        @if ($errors->has('role'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <a href="{{ route('user.show', $user) }}" class="btn btn-secondary">返回會員資料</a>
                        <button type="submit" class="btn btn-primary"> 更新會員資料</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
