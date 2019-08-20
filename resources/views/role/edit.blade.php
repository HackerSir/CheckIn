@extends('layouts.base')

@section('title', '編輯角色')

@section('buttons')
    <a href="{{ route('role.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>角色管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('role.update', $role), ['model' => $role]) }}
            @if($role->protection)
                {{ bs()->formGroup(bs()->text('name')->readOnly()->placeholder('如：admin'))->class('required')->label('英文名稱')->showAsRow() }}
            @else
                {{ bs()->formGroup(bs()->text('name')->required()->placeholder('如：admin'))->class('required')->label('英文名稱')->showAsRow() }}
            @endif
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
