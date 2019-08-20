@extends('layouts.base')

@section('title', '學生管理')

@section('buttons')
    @can('create', \App\Student::class)
        <a href="{{ route('student.create-real-student') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle mr-2"></i>新增學生
        </a>
        <a href="{{ route('student.create') }}" class="btn btn-secondary">
            <i class="fa fa-plus-circle mr-2"></i>新增虛擬學生
        </a>
    @endcan
    @can('import', \App\Student::class)
        <a href="{{ route('student.import') }}" class="btn btn-primary">
            <i class="fas fa-file-upload mr-2"></i>匯入學生
        </a>
    @endcan
@endsection

@section('container_class', 'container-fluid')
@section('main_content')
    <div class="alert alert-warning">
        <ul class="list-unstyled mb-0">
            <li><i class="fas fa-exclamation-triangle mr-2"></i><strong>虛構資料</strong>意味著該筆資料為人為輸入，待該使用者登入後，將自動替換為學校提供之實際資料
            </li>
            <li><i class="fas fa-exclamation-triangle mr-2"></i>來自學校API之實際資料無法被編輯或刪除（僅能修改<code>視為新生</code>選項）</li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
