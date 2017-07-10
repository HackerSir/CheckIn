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
    <div class="card">
        <div class="card-header">
            個人資料
        </div>
        <div class="text-center">
            {{-- Gravatar大頭貼 --}}
            <a href="https://zh-tw.gravatar.com/" target="_blank" title="透過Gravatar更換照片">
                <img src="{{ Gravatar::src($user->email, 200) }}" class="img-thumbnail" id="gravatar"/>
            </a>
        </div>
        <div class="card-block">
            <table class="table table-hover">
                <tr>
                    <td class="text-md-right">名稱：</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="text-md-right">Email：</td>
                    <td>{{ $user->email }}</td>
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
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">編輯資料</a>
            <a href="{{ route('password.change') }}" class="btn btn-primary">修改密碼</a>
        </div>
    </div>
@endsection
