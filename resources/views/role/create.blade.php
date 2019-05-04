@extends('layouts.base')

@section('title', '新增角色')

@section('buttons')
    <a href="{{ route('role.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 角色管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('role.store')) }}
            {{ bs()->formGroup(bs()->text('name')->required()->placeholder('如：admin'))->class('required')->label('英文名稱')->showAsRow() }}
            @include('role.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
