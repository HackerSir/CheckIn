@extends('layouts.base')

@section('title', '聯絡資料')

@section('buttons')
    @can('create', \App\Models\ContactInformation::class)
        <a href="{{ route('contact-information.create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle mr-2"></i>新增聯絡資料
        </a>
    @endcan
@endsection

@section('container_class', 'container-fluid')
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
