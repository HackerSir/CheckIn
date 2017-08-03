@extends('layouts.app')

@section('title', '額外抽獎編號管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>額外抽獎編號管理</h1>
        <a href="{{ route('extra-ticket.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增額外抽獎編號
        </a>
        <a href="{{ route('extra-ticket.ticket') }}" class="btn btn-primary" target="_blank">
            <i class="fa fa-external-link" aria-hidden="true"></i> 額外抽獎編號展示
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
