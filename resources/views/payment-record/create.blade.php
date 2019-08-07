@extends('layouts.base')

@section('title', '新增繳費紀錄')

@section('buttons')
    <a href="{{ route('payment-record.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>繳費紀錄管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('payment-record.store')) }}
            @include('payment-record.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
