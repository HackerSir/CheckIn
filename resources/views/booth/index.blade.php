@extends('layouts.base')

@section('title', '攤位管理')

@section('buttons')
    <a href="{{ route('booth.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle mr-2"></i>新增攤位
    </a>
    <a href="{{ route('booth.import') }}" class="btn btn-primary">
        <i class="fa fa-upload mr-2"></i>匯入
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
