@extends('layouts.app')

@section('title', '攤位管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>攤位管理</h1>
        <a href="{{ route('booth.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增攤位
        </a>
        <a href="{{ route('booth.import') }}" class="btn btn-primary">
            <i class="fa fa-upload" aria-hidden="true"></i> 匯入
        </a>
        <div class="card mt-1">
            <div class="card-body">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
