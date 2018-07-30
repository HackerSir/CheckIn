@extends('layouts.app')

@section('title', '抽獎編號管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>抽獎編號管理</h1>
        <a href="{{ route('ticket.ticket') }}" class="btn btn-primary" target="_blank">
            <i class="fa fa-external-link" aria-hidden="true"></i> 抽獎編號展示
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
