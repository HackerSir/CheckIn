@extends('layouts.base')

@section('title', '新增學生')

@section('buttons')
    <a href="{{ route('student.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('student.store')) }}
            {{ bs()->formGroup(bs()->text('nid')->required()->autofocus())->label('學號')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('新增學生', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
