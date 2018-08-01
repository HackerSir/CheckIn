@extends('layouts.base')

@php
    $isEditMode = isset($booth);
    $methodText = $isEditMode ? '編輯' : '新增';
@endphp

@section('title', $methodText . '攤位')

@section('buttons')
    @if($isEditMode)
        <a href="{{ route('booth.show', $booth) }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
        </a>
    @else
        <a href="{{ route('booth.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 攤位管理
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            @if($isEditMode)
                {{ Form::model($booth, ['route' => ['booth.update', $booth], 'method' => 'patch']) }}
            @else
                {{ Form::open(['route' => 'booth.store']) }}
            @endif

            <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label for="name" class="col-md-2 col-form-label">攤位編號</label>
                <div class="col-md-10">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => '如：A01', 'required']) }}
                    @if ($errors->has('name'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('club_id') ? ' has-danger' : '' }}">
                <label for="club_id" class="col-md-2 col-form-label">社團</label>
                <div class="col-md-10">
                    {{ Form::select('club_id', \App\Club::selectOptions(), null, ['class' => 'form-control']) }}
                    @if ($errors->has('club_id'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('club_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('latitude') ? ' has-danger' : '' }}">
                <label for="latitude" class="col-md-2 col-form-label">緯度</label>
                <div class="col-md-10">
                    {{ Form::text('latitude', null, ['class' => 'form-control']) }}
                    @if ($errors->has('latitude'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('latitude') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('longitude') ? ' has-danger' : '' }}">
                <label for="longitude" class="col-md-2 col-form-label">經度</label>
                <div class="col-md-10">
                    {{ Form::text('longitude', null, ['class' => 'form-control']) }}
                    @if ($errors->has('longitude'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('longitude') }}</strong>
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

@section('js')
    <script>
        $(function () {
            $('select[name=club_id]').select2();
        });
    </script>
@endsection
