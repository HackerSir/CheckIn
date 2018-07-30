@extends('layouts.app')

@php
    $isEditMode = isset($clubType);
    $methodText = $isEditMode ? '編輯' : '新增';
@endphp

@section('title', $methodText . '社團類型')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('club-type.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團類型管理
            </a>
            <h1>{{ $methodText }}社團類型</h1>
            <div class="card">
                <div class="card-body">
                    @if($isEditMode)
                        {{ Form::model($clubType, ['route' => ['club-type.update', $clubType], 'method' => 'patch']) }}
                    @else
                        {{ Form::open(['route' => 'club-type.store']) }}
                    @endif

                    <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-md-2 col-form-label">名稱</label>
                        <div class="col-md-10">
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => '如：學藝性', 'required']) }}
                            @if ($errors->has('name'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('color') ? ' has-danger' : '' }}">
                        <label for="color" class="col-md-2 col-form-label">標籤顏色</label>
                        <div class="col-md-10">
                            {{ Form::color('color', null, ['class' => 'form-control', 'style' => 'padding:.1rem .2rem; height: 100%']) }}
                            @if ($errors->has('color'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('is_counted') ? ' has-danger' : '' }}">
                        <label for="is_counted" class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <div class="custom-control custom-checkbox">
                                {{ Form::checkbox('is_counted', true, null, ['id' => 'is_counted', 'class' => 'custom-control-input']) }}
                                <label class="custom-control-label" for="is_counted">
                                    列入抽獎集點
                                </label>
                            </div>
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
