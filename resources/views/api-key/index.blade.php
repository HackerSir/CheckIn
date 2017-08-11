@extends('layouts.app')

@section('title', 'API Key管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>API Key管理</h1>
        <a href="{{ route('api-key.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增API Key
        </a>
        <div class="card mt-1">
            <div class="card-block">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
@endsection
