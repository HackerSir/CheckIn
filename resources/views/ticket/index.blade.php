@extends('layouts.base')

@section('title', '抽獎編號管理')

@section('buttons')
    <a href="{{ route('ticket.ticket') }}" class="btn btn-primary" target="_blank">
        <i class="fa fa-external-link-alt mr-2"></i>抽獎編號展示
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
