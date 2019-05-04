@extends('layouts.base')

@section('title', '管理員登入')

@section('main_content')
    <div class="card">
        <div class="card-body">
            <div class="alert alert-warning" role="alert">
                <strong>警告！</strong>學生請使用<a href="{{ route('oauth.index') }}" class="alert-link">NID登入</a>
            </div>
            {{ bs()->openForm('post', route('login')) }}
            {{ bs()->formGroup(bs()->text('email')->required())->class('required')->label('信箱')->showAsRow() }}
            {{ bs()->formGroup(bs()->password('password')->required())->class('required')->label('密碼')->showAsRow() }}
            {{ bs()->formGroup(bs()->checkBox('remember', '記住我'))->showAsRow('no_label') }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('登入', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                    {{ bs()->a(route('register'), '註冊')->asButton('light')->prependChildren(fa()->icon('user-plus')->addClass('mr-2')) }}
                    {{ bs()->a(route('password.request'), '忘記密碼')->asButton('light')->prependChildren(fa()->icon('question-circle')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
