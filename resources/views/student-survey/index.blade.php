@extends('layouts.base')

@section('title', '學生問卷')

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
