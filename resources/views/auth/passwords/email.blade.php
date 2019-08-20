@extends('layouts.base')

@section('title', '重設密碼')

@section('buttons')
    <a href="{{ route('login') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>返回
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {{ bs()->openForm('post', route('password.email')) }}
            {{ bs()->formGroup(bs()->email('email')->required())->class('required')->label('信箱')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('發送重設密碼信件', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
