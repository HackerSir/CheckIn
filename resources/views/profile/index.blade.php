@extends('layouts.base')

@section('title', '個人資料')

@section('buttons')
    @if($user->is_local_account)
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="fa fa-edit mr-2"></i>編輯資料
        </a>
        <a href="{{ route('password.change') }}" class="btn btn-primary">
            <i class="fa fa-key mr-2"></i>修改密碼
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-3">名稱</dt>
                <dd class="col-8 col-md-9">{{ $user->name }}</dd>

                @if($user->is_local_account)
                    <dt class="col-4 col-md-3">Email</dt>
                    <dd class="col-8 col-md-9">
                        {{ $user->email }}
                        @if (!$user->isConfirmed)
                            <i class="fa fa-exclamation-triangle text-danger" title="尚未完成信箱驗證"></i>
                        @endif
                    </dd>
                    <dt class="col-4 col-md-3">兩步驟驗證</dt>
                    <dd class="col-8 col-md-9">
                        @if($user->google2fa_secret)
                            <span class="text-success">已啟用</span>
                        @else
                            <span class="text-danger">未啟用</span>
                        @endif
                        <a href="{{ route('profile.2fa.index') }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </dd>
                @else
                    <dt class="col-4 col-md-3">NID</dt>
                    <dd class="col-8 col-md-9">{{ $user->nid }}</dd>
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
    </div>
@endsection
