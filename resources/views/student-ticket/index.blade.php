@extends('layouts.base')

@section('title', '學生抽獎編號管理')

@section('buttons')
    <a href="{{ route('student-ticket.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增學生抽獎編號
    </a>
    <a href="{{ route('student-ticket.import') }}" class="btn btn-primary">
        <i class="fa fa-upload" aria-hidden="true"></i> 匯入
    </a>
    {!! Form::open(['route' => ['student-ticket.destroy-all'], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要全部刪除嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-times" aria-hidden="true"></i> 全部刪除
    </button>
    {!! Form::close() !!}

    <a href="{{ route('student-ticket.ticket') }}" class="btn btn-primary" target="_blank">
        <i class="fa fa-external-link-alt" aria-hidden="true"></i> 學生抽獎編號展示
    </a>
@endsection

@section('main_content')
    <div class="alert alert-warning mb-2">
        此功能僅作為社團博覽會無法順利舉行時之備案，正式的抽獎編號請至 {{ link_to_route('ticket.index', '抽獎編號管理') }}
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
