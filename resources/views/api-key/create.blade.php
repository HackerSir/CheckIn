@extends('layouts.app')

@section('title', '新增API Key')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('api-key.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> API Key管理
            </a>
            <h1>新增API Key</h1>
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
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check" aria-hidden="true"></i> 確認
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
