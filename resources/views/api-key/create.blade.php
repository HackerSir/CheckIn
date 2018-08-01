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
            {{ Form::open(['route' => 'api-key.store']) }}

            <div class="form-group row{{ $errors->has('api_key') ? ' has-danger' : '' }}">
                <label for="api_key" class="col-md-2 col-form-label">API Key</label>
                <div class="col-md-10">
                    {{ Form::text('api_key', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) }}
                    @if ($errors->has('api_key'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('api_key') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="mx-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check" aria-hidden="true"></i> 確認
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
