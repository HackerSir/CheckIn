@extends('layouts.base')

@section('title', '編輯聯絡資料')

@section('buttons')
    <a href="{{ route('contact-information.my.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>檢視聯絡資料
    </a>
@endsection

@section('main_content')
    @include('contact-information.my.alert')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('contact-information.my.store'), ['model' => $contactInformation]) }}
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
