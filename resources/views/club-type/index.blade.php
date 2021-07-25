@extends('layouts.base')

@section('title', '社團類型管理')

@section('buttons')
    <a href="{{ route('club-type.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle mr-2"></i>新增社團類型
    </a>
    @if(\App\Models\ClubType::count() == 0)
        {{ Form::open(['route' => 'club-type.store-default', 'style' => 'display: inline-block']) }}
        <button type="submit" class="btn btn-success">
            <i class="fa fa-plus-circle mr-2"></i>建立預設社團類型
        </button>
        {{ Form::close() }}
    @endif
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
