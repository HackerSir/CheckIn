@extends('layouts.app')

@php
    $isEditMode = isset($extraTicket);
    $methodText = $isEditMode ? '編輯' : '新增';
@endphp

@section('title', $methodText . '隊輔抽獎編號')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>{{ $methodText }}隊輔抽獎編號</h1>
            <div class="card">
                <div class="card-block">
                    @if($isEditMode)
                        {{ Form::model($extraTicket, ['route' => ['extra-ticket.update', $extraTicket], 'method' => 'patch']) }}
                    @else
                        {{ Form::open(['route' => 'extra-ticket.store']) }}
                    @endif

                    <div class="form-group row{{ $errors->has('id') ? ' has-danger' : '' }}">
                        <label for="id" class="col-md-2 col-form-label">抽獎編號</label>
                        <div class="col-md-10">
                            @if($isEditMode)
                                {{ Form::number('id', null, ['class' => 'form-control', 'disabled']) }}
                            @else
                                {{ Form::number('id', null, ['class' => 'form-control', 'min' => '1', 'placeholder' => '如：1']) }}
                                @if ($errors->has('id'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('id') }}</strong>
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('nid') ? ' has-danger' : '' }}">
                        <label for="nid" class="col-md-2 col-form-label">學號</label>
                        <div class="col-md-10">
                            {{ Form::text('nid', null, ['class' => 'form-control', 'placeholder' => '如：M0402935']) }}
                            @if ($errors->has('nid'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('nid') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="col-md-2 col-form-label">姓名</label>
                        <div class="col-md-10">
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => '如：許展源']) }}
                            @if ($errors->has('name'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('class') ? ' has-danger' : '' }}">
                        <label for="class" class="col-md-2 col-form-label">系級</label>
                        <div class="col-md-10">
                            {{ Form::text('class', null, ['class' => 'form-control', 'placeholder' => '如：資訊碩二']) }}
                            @if ($errors->has('class'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('class') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary"> 確認</button>
                            <a href="{{ route('extra-ticket.index') }}" class="btn btn-secondary">返回列表</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
