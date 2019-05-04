@extends('layouts.base')

@section('title', '編輯個人資料')

@section('buttons')
    <a href="{{ route('profile') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 個人資料
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('put', route('profile.update'), ['model' => $user]) }}
            {{ bs()->formGroup(bs()->email('email')->readOnly())->label('信箱')
             ->helpText('信箱作為帳號使用，故無法修改')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('name')->required())->class('required')->label('名稱')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
