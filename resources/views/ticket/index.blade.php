@extends('layouts.base')

@section('title', '抽獎編號管理')

@section('buttons')
    <a href="{{ route('ticket.ticket') }}" class="btn btn-primary" target="_blank">
        <i class="fa fa-external-link-alt mr-2"></i>抽獎編號展示
    </a>
    {!! Form::open(['route' => ['export.ticket'], 'style' => 'display: inline']) !!}
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-download mr-2"></i>匯出
    </button>
    {!! Form::close() !!}
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
