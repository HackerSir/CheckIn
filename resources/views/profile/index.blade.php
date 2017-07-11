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
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>個人資料</h1>
            <div class="card">
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
                        @if($user->is_local_account)
                        <tr>
                            <td class="text-md-right">兩步驟驗證：</td>
                            <td>

                                @if($user->google2fa_secret)
                                    <span class="text-success">已啟用</span>
                                @else
                                    <span class="text-danger">未啟用</span>
                                @endif
                                <a href="{{ route('profile.2fa.index') }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
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
