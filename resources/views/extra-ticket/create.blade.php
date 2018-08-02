@extends('layouts.base')

@section('title', '新增工作人員抽獎編號')

@section('buttons')
    <a href="{{ route('extra-ticket.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 工作人員抽獎編號管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('extra-ticket.store')) }}
            {{ bs()->formGroup(bs()->input('number', 'id')->attributes(['min' => 1])->placeholder('如：1'))->label('抽獎編號')->showAsRow() }}
            @include('extra-ticket.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
