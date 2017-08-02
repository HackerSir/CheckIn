@extends('layouts.app')

@section('title', '社團類型管理')

@section('content')
    <div class="mt-3 pb-3">
        <h1>社團類型管理</h1>
        <a href="{{ route('club-type.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> 新增社團類型
        </a>
        @if(\App\ClubType::count() == 0)
            {{ Form::open(['route' => 'club-type.store-default', 'style' => 'display: inline-block']) }}
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> 建立預設社團類型
            </button>
            {{ Form::close() }}
        @endif
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
