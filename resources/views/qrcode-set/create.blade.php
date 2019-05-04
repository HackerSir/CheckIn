@extends('layouts.base')

@section('title', '新增 QR Code 集')

@section('buttons')
    <a href="{{ route('qrcode-set.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code 集
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('qrcode-set.store')) }}
            {{ bs()->formGroup(bs()->input('number', 'amount', 1)->required()->autofocus()->attributes(['min' => 1]))->class('required')->label('QR碼數量')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('新增 QR Code 集', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
