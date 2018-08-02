@extends('layouts.base')

@section('title', '新增 API Key')

@section('buttons')
    <a href="{{ route('api-key.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> API Key 管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('api-key.store')) }}
            {{ bs()->formGroup(bs()->text('api_key')->required()->attribute('autocomplete', 'off'))->label('API Key')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
            {{ Form::open(['route' => 'api-key.store']) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
