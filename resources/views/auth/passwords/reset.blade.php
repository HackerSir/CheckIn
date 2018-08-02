@extends('layouts.base')

@section('title', '重設密碼')

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('password.request')) }}
            {{ bs()->hidden('token', $token) }}
            {{ bs()->formGroup(bs()->email('email')->required())->label('信箱')->showAsRow() }}
            {{ bs()->formGroup(bs()->password('password')->required())->label('密碼')->showAsRow() }}
            {{ bs()->formGroup(bs()->password('password_confirmation')->required())->label('確認密碼')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('重設密碼', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
