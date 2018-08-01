@extends('layouts.base')

@section('title', 'API Key 管理')

@section('buttons')
    <a href="{{ route('api-key.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增 API Key
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
