@extends('layouts.base')

@section('title', $paymentRecord->club->name . ' - ' . $paymentRecord->nid . ' - 編輯繳費紀錄')

@section('buttons')
    <a href="{{ route('payment-record.show', $paymentRecord) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>檢視繳費紀錄
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('payment-record.update', $paymentRecord), ['model' => $paymentRecord]) }}
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
