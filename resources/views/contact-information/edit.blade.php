@extends('layouts.base')

@section('title', $contactInformation->student->name . ' - 編輯聯絡資料')

@section('buttons')
    <a href="{{ route('contact-information.show', $contactInformation) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>檢視聯絡資料
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('contact-information.update', $contactInformation), ['model' => $contactInformation]) }}
            {{ bs()->formGroup(html()->div($contactInformation->student->name)->class('form-control-plaintext'))->label('學生')->showAsRow() }}
            {{ bs()->hidden('student_nid', $contactInformation->student_nid) }}
            @include('contact-information.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
