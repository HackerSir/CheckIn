@extends('layouts.base')

@section('title', '修改密碼')

@section('buttons')
    <a href="{{ route('profile') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 個人資料
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('put', route('password.change')) }}
            {{ bs()->formGroup(bs()->password('password')->required())->class('required')->label('密碼')->showAsRow() }}
            {{ bs()->formGroup(bs()->password('new_password')->required())->class('required')->label('新密碼')->showAsRow() }}
            {{ bs()->formGroup(bs()->password('new_password_confirmation')->required())->class('required')->label('確認新密碼')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
