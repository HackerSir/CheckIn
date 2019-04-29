{{ bs()->formGroup(bs()->text('nid')->required()->readOnly())->class('required')->label('NID')->showAsRow() }}
{{ bs()->formGroup(bs()->text('name')->required()->readOnly())->class('required')->label('姓名')->showAsRow() }}
{{ bs()->formGroup(bs()->text('class')->readOnly())->label('班級')->showAsRow() }}
{{ bs()->formGroup(bs()->text('type')->readOnly())->label('類型')->showAsRow() }}
{{ bs()->formGroup(bs()->text('unit_id')->readOnly())->label('科系ID')->showAsRow() }}
{{ bs()->formGroup(bs()->text('unit_name')->readOnly())->label('科系')->showAsRow() }}
{{ bs()->formGroup(bs()->text('dept_id')->readOnly())->label('學院ID')->showAsRow() }}
{{ bs()->formGroup(bs()->text('dept_name')->readOnly())->label('學院')->showAsRow() }}
{{ bs()->formGroup(bs()->input('number', 'in_year')->readOnly())->label('入學學年度')->showAsRow() }}
{{ bs()->formGroup(bs()->text('gender')->readOnly())->label('性別')->showAsRow() }}
{{ bs()->formGroup(bs()->checkBox('consider_as_freshman', '視為新生'))->helpText('強制將此學生視為新生')->showAsRow('no_label') }}
