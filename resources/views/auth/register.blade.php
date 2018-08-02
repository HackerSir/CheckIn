@extends('layouts.base')

@section('title', '管理員註冊')

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post',route('register')) }}
            {{ bs()->formGroup(bs()->text('name')->required())->label('名稱')->showAsRow() }}
            {{ bs()->formGroup(bs()->email('email')->required())->label('信箱')->showAsRow() }}
            {{ bs()->formGroup(bs()->password('password')->required())->label('密碼')->showAsRow() }}
            {{ bs()->formGroup(bs()->password('password_confirmation')->required())->label('確認密碼')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('註冊', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                    {{ bs()->a(route('login'), '登入')->asButton('light')->prependChildren(fa()->icon('sign-in-alt')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
