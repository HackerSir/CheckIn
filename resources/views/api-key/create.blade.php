@extends('layouts.app')

@section('title', '新增ApiKey')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>新增ApiKey</h1>
            <div class="card">
                <div class="card-block">
                    {{ Form::open(['route' => 'api-key.store']) }}

                    <div class="form-group row{{ $errors->has('api_key') ? ' has-danger' : '' }}">
                        <label for="api_key" class="col-md-2 col-form-label">ApiKey</label>
                        <div class="col-md-10">
                            {{ Form::text('api_key', null, ['class' => 'form-control', 'required']) }}
                            @if ($errors->has('api_key'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('api_key') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary"> 確認</button>
                            <a href="{{ route('api-key.index') }}" class="btn btn-secondary">返回列表</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
