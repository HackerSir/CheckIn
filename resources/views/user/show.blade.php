@extends('layouts.base')

@section('title', "{$user->name} - 會員資料")

@section('buttons')
    <a href="{{ route('user.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>會員清單
    </a>
    <a href="{{ route('user.edit', $user) }}" class="btn btn-primary">
        <i class="fa fa-edit mr-2"></i>編輯資料
    </a>
    {!! Form::open(['route' => ['user.destroy', $user], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此會員嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-trash mr-2"></i>刪除會員
    </button>
    {!! Form::close() !!}
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

                @if($user->student && Laratrust::isAbleTo('student.manage'))
                    <dt class="col-4 col-md-3">學生</dt>
                    <dd class="col-8 col-md-9">
                        {{ link_to_route('student.show', $user->student->display_name, $user->student) }}
                    </dd>
                @endif

                @if($user->club)
                    <dt class="col-4 col-md-3">負責社團</dt>
                    <dd class="col-8 col-md-9">
                        <a href="{{ route('clubs.show', $user->club) }}">
                            {!! $user->club->display_name !!}
                        </a>
                    </dd>
                @endif
            </dl>
        </div>
    </div>
@endsection
