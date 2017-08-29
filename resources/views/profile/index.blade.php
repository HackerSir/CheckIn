@extends('layouts.app')

@section('title', '個人資料')

@section('css')
    <style>
        #gravatar:hover {
            border: 1px dotted black;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>個人資料</h1>
            <div class="card">
                <div class="card-block text-center">
                    {{-- Gravatar大頭貼 --}}
                    <a href="https://zh-tw.gravatar.com/" target="_blank" title="透過Gravatar更換照片">
                        <img src="{{ Gravatar::src($user->email, 200) }}" class="img-thumbnail" id="gravatar"/>
                    </a>
                </div>
                <div class="card-block">
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-3">名稱</dt>
                        <dd class="col-8 col-md-9">{{ $user->name }}</dd>

                        <dt class="col-4 col-md-3">Email</dt>
                        <dd class="col-8 col-md-9">
                            {{ $user->email }}
                            @if (!$user->isConfirmed)
                                <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"
                                   title="尚未完成信箱驗證"></i>
                            @endif
                        </dd>

                        @if($user->is_local_account)
                            <dt class="col-4 col-md-3">兩步驟驗證</dt>
                            <dd class="col-8 col-md-9">
                                @if($user->google2fa_secret)
                                    <span class="text-success">已啟用</span>
                                @else
                                    <span class="text-danger">未啟用</span>
                                @endif
                                <a href="{{ route('profile.2fa.index') }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                            </dd>
                        @endif

                        <dt class="col-4 col-md-3">角色</dt>
                        <dd class="col-8 col-md-9">
                            @foreach($user->roles as $role)
                                {{ $role->display_name }}<br/>
                            @endforeach
                        </dd>

                        <dt class="col-4 col-md-3">註冊時間</dt>
                        <dd class="col-8 col-md-9">{{ $user->register_at }}</dd>

                        <dt class="col-4 col-md-3">註冊IP</dt>
                        <dd class="col-8 col-md-9">{{ $user->register_ip }}</dd>

                        <dt class="col-4 col-md-3">最後登入時間</dt>
                        <dd class="col-8 col-md-9">{{ $user->last_login_at }}</dd>

                        <dt class="col-4 col-md-3">最後登入IP</dt>
                        <dd class="col-8 col-md-9">{{ $user->last_login_ip }}</dd>
                    </dl>
                </div>
                @if($user->is_local_account)
                    <div class="card-block text-center">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">編輯資料</a>
                        <a href="{{ route('password.change') }}" class="btn btn-primary">修改密碼</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
