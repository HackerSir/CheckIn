@extends('layouts.app')

@section('title', "{$user->name} - 會員資料")

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
            <a href="{{ route('user.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 會員清單
            </a>
            <h1>{{ $user->name }} - 會員資料</h1>
            <div class="card">
                <div class="card-block text-center">
                    {{-- Gravatar大頭貼 --}}
                    <img src="{{ Gravatar::src($user->email, 200) }}" class="img-thumbnail" id="gravatar"
                         title="Gravatar大頭貼"/>
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">名稱：</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">Email：</td>
                            <td>
                                {{ $user->email }}
                                @if (!$user->isConfirmed)
                                    <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"
                                       title="尚未完成信箱驗證"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">角色：</td>
                            <td>
                                @foreach($user->roles as $role)
                                    {{ $role->display_name }}<br/>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">註冊時間：</td>
                            <td>{{ $user->register_at }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">註冊IP：</td>
                            <td>{{ $user->register_ip }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">最後登入時間：</td>
                            <td>{{ $user->last_login_at }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">最後登入IP：</td>
                            <td>{{ $user->last_login_ip }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-block text-center">
                    <a href="{{ route('user.edit', $user) }}" class="btn btn-primary">編輯資料</a>
                    {!! Form::open(['route' => ['user.destroy', $user], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此會員嗎？');"]) !!}
                    <button type="submit" class="btn btn-danger">刪除會員</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
