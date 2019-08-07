@extends('layouts.base')

@section('title', '繳費紀錄')

@section('container_class', 'container-fluid')
@section('buttons')
    <a href="{{ route('payment-record.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle mr-2"></i>新增
    </a>
{{--    {!! Form::open(['route' => ['export.feedback'], 'style' => 'display: inline']) !!}--}}
{{--    <button type="submit" class="btn btn-primary">--}}
{{--        <i class="fa fa-download" aria-hidden="true"></i> 匯出--}}
{{--    </button>--}}
{{--    {!! Form::close() !!}--}}
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
