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
    <div class="alert alert-warning mb-1">
        <ul class="list-unstyled mb-0">
            <li>若<code>對應學生</code>欄位空白，表示該 NID 無效、該學生未填寫回饋資料，或該學生於回饋資料中表示對於參與社團與茶會皆無意願</li>
        </ul>
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
