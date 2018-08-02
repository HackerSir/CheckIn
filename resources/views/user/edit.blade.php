@extends('layouts.base')

@section('title', "{$user->name} - 編輯會員資料")

@section('buttons')
    <a href="{{ route('user.show', $user) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 會員資料
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('user.update', $user), ['model' => $user]) }}
            {{ bs()->formGroup(bs()->email('email')->readOnly())->label('信箱')->helpText('信箱作為帳號使用，故無法修改')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('name')->required())->label('名稱')->showAsRow() }}

            <div class="form-group row">
                <label class="col-md-2 col-form-label">角色</label>
                <div class="col-md-10" style="padding-top: calc(.5rem - 1px * 2);">
                    @foreach($roles as $role)
                        @if($user->id == Auth::user()->id && $role->name == 'Admin')
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="role[]" value="{{ $role->id }}"
                                       class="custom-control-input" id="roleCheck{{ $role->id }}"
                                       @if($user->hasRole($role->name)) checked disabled @endif>
                                <label class="custom-control-label" for="roleCheck{{ $role->id }}">
                                    {{ $role->display_name }}（{{ $role->description }}）
                                    <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"
                                       title="禁止解除自己的管理員職務"></i>
                                </label>
                            </div>
                        @else
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="role[]" value="{{ $role->id }}"
                                       class="custom-control-input" id="roleCheck{{ $role->id }}"
                                       @if($user->hasRole($role->name)) checked @endif>
                                <span class="custom-control-indicator"></span>
                                <label class="custom-control-label" for="roleCheck{{ $role->id }}">
                                    {{ $role->display_name }}（{{ $role->description }}）
                                </label>
                            </div>
                        @endif
                        <br/>
                    @endforeach
                    @if ($errors->has('role'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('更新會員資料', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
