@extends('layouts.base')

@section('title', $student->name . ' - 編輯學生')

@section('buttons')
    <a href="{{ route('student.show', $student) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 檢視學生
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('student.update', $student), ['model' => $student]) }}
            {{ bs()->formGroup(bs()->text('nid')->disabled())->label('學號')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('name')->disabled())->label('姓名')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('class')->disabled())->label('班級')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('unit_name')->disabled())->label('科系')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('dept_name')->disabled())->label('學院')->showAsRow() }}
            {{ bs()->formGroup(bs()->input('number', 'in_year')->disabled())->label('入學學年度')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('gender')->disabled())->label('性別')->showAsRow() }}
            {{ bs()->formGroup(bs()->checkBox('consider_as_freshman', '視為新生'))->helpText('強制將此學生視為新生')->showAsRow('no_label') }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
