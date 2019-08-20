@extends('layouts.base')

@section('title', '新增虛擬學生')

@section('buttons')
    <a href="{{ route('student.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>學生管理
    </a>
@endsection

@section('main_content')
    <div class="alert alert-warning">
        <ul class="list-unstyled mb-0">
            <li>
                <i class="fas fa-exclamation-triangle mr-2"></i>此功能用於使用虛構資料建立虛擬學生，除非無法透過
                {{ link_to_route('student.create-real-student', '新增學生') }}
                處理，否則應避免使用此功能
            </li>
            <li>
                <i class="fas fa-exclamation-triangle mr-2"></i>若欲直接使用學校提供之實際資料建立實際學生，請使用
                {{ link_to_route('student.create-real-student', '新增學生') }}
                功能
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('student.store')) }}
            @include('student.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('新增學生', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
