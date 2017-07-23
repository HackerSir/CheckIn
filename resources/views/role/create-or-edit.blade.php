@extends('layouts.app')

@php($isEditMode = isset($role))
@php($methodText = $isEditMode ? '編輯' : '新增')

@section('title', $methodText . '角色')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>{{ $methodText }}角色</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST"
                          action="{{ $isEditMode ? route('role.update', $role) : route('role.store') }}">
                        @if($isEditMode)
                            {{ method_field('patch') }}
                        @endif
                        {{ csrf_field() }}
                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name" class="col-md-2 col-form-label">英文名稱</label>
                            <div class="col-md-10">
                                @if($isEditMode && $role->protection)
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}"
                                           name="name"
                                           value="{{ $role->name }}"
                                           placeholder="如：admin" disabled>
                                    {!! Form::hidden('name', $role->name) !!}
                                @else
                                    <input id="name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}"
                                           name="name"
                                           value="{{ $role->name or '' }}"
                                           placeholder="如：admin" required>
                                @endif
                                @if ($errors->has('name'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('display_name') ? ' has-danger' : '' }}">
                            <label for="display_name" class="col-md-2 col-form-label">顯示名稱</label>
                            <div class="col-md-10">
                                <input id="display_name" type="text"
                                       class="form-control{{ $errors->has('display_name') ? ' form-control-danger' : '' }}"
                                       value="{{ $role->display_name or '' }}"
                                       name="display_name"
                                       placeholder="如：管理員">
                                @if ($errors->has('display_name'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('display_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                            <label for="description" class="col-md-2 col-form-label">簡介</label>
                            <div class="col-md-10">
                                <input id="description" type="text"
                                       class="form-control{{ $errors->has('description') ? ' form-control-danger' : '' }}"
                                       value="{{ $role->description or ''}}"
                                       name="description"
                                       placeholder="說明此角色之用途">
                                @if ($errors->has('description'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="col-md-2 col-form-label">權限</label>
                            <div class="col-md-10" style="padding-top: calc(.5rem - 1px * 2);">
                                @foreach($permissions as $permission)
                                    @if(isset($role) && $role->protection)
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                   class="custom-control-input"
                                                   @if(isset($role) && $role->permissions->contains($permission)) checked
                                                   @endif
                                                   disabled>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">
                                                {{ $permission->display_name }}（{{ $permission->name }}）<br/>
                                                <small>
                                                    <i class="fa fa-angle-double-right"
                                                       aria-hidden="true"></i> {{ $permission->description}}
                                                </small>
                                            </span>
                                        </label>
                                    @else
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                   class="custom-control-input"
                                                   @if(isset($role) && $role->permissions->contains($permission)) checked @endif>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">
                                                {{ $permission->display_name }}（{{ $permission->name }}）<br/>
                                                <small>
                                                    <i class="fa fa-angle-double-right"
                                                       aria-hidden="true"></i> {{ $permission->description }}
                                                </small>
                                            </span>
                                        </label>
                                    @endif
                                    <br/>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary"> 確認</button>
                                <a href="{{ route('role.index') }}" class="btn btn-secondary">返回列表</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
