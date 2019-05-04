@extends('layouts.base')

@section('title', '新增學生')

@section('buttons')
    <a href="{{ route('student.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生管理
    </a>
@endsection

@section('main_content')
    <div class="alert alert-warning">
        <ul class="list-unstyled mb-0">
            <li><i class="fas fa-exclamation-triangle mr-2"></i>此功能用於使用學校提供之實際資料建立實際學生
            </li>
            <li><i class="fas fa-exclamation-triangle mr-2"></i>若資料已存在於資料庫，則會嘗試更新該學號對應資料
            </li>
            <li>
                <i class="fas fa-exclamation-triangle mr-2"></i>若無法透過此功能取得學生資料，且欲使用虛構資料建立虛擬學生，請使用
                {{ link_to_route('student.create', '新增虛擬學生') }}
                功能
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('student.store-real-student')) }}
            {{ bs()->formGroup(bs()->text('nid')->required()->autofocus())->class('required')->label('學號')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('新增學生', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
