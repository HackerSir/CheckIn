@extends('layouts.app')

@section('title', '抽獎編號管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>抽獎編號管理</h1>
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
