@extends('layouts.base')

@section('title', '學生問卷')

@section('buttons')
    {!! Form::open(['route' => ['export.student-survey'], 'style' => 'display: inline']) !!}
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-download mr-2"></i>匯出
    </button>
    {!! Form::close() !!}
@endsection

@section('main_content')
    <div class="mt-3 pb-3">
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
