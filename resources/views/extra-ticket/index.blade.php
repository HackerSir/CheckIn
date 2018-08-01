@extends('layouts.base')

@section('title', '工作人員抽獎編號管理')

@section('buttons')
    <a href="{{ route('extra-ticket.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增工作人員抽獎編號
    </a>
    <a href="{{ route('extra-ticket.import') }}" class="btn btn-primary">
        <i class="fa fa-upload" aria-hidden="true"></i> 匯入
    </a>
    {!! Form::open(['route' => ['extra-ticket.destroy-all'], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要全部刪除嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-times" aria-hidden="true"></i> 全部刪除
    </button>
    {!! Form::close() !!}

    <a href="{{ route('extra-ticket.ticket') }}" class="btn btn-primary" target="_blank">
        <i class="fa fa-external-link-alt" aria-hidden="true"></i> 工作人員抽獎編號展示
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
