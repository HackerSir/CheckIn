{{ bs()->formGroup(bs()->text('display_name')->required()->placeholder('如：管理員'))->class('required')->label('顯示名稱')->showAsRow() }}
{{ bs()->formGroup(bs()->text('description')->required()->placeholder('說明此角色之用途'))->class('required')->label('簡介')->showAsRow() }}

<div class="form-group row">
    <label class="col-md-2 col-form-label">權限</label>
    <div class="col-md-10" style="padding-top: calc(.5rem - 1px * 2);">
        @foreach($permissions as $permission)
            @if(isset($role) && $role->protection)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                           class="custom-control-input" id="permissionCheck{{ $permission->id }}"
                           @if(isset($role) && $role->permissions->contains($permission)) checked @endif
                           disabled>
                    <label class="custom-control-label" for="permissionCheck{{ $permission->id }}">
                        {{ $permission->display_name }}（{{ $permission->name }}）<br/>
                        <small>
                            <i class="fa fa-angle-double-right mr-2"></i>{{ $permission->description }}
                        </small>
                    </label>
                </div>
            @else
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                           class="custom-control-input" id="permissionCheck{{ $permission->id }}"
                           @if(isset($role) && $role->permissions->contains($permission)) checked @endif>
                    <label class="custom-control-label" for="permissionCheck{{ $permission->id }}">
                        {{ $permission->display_name }}（{{ $permission->name }}）<br/>
                        <small>
                            <i class="fa fa-angle-double-right mr-2"></i>{{ $permission->description }}
                        </small>
                    </label>
                </div>
            @endif
            <br/>
        @endforeach
    </div>
</div>
