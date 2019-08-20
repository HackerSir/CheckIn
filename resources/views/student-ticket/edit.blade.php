@extends('layouts.base')

@php
    $isEditMode = isset($studentTicket);
    $methodText = $isEditMode ? '編輯' : '新增';
@endphp

@section('title', $methodText . '學生抽獎編號')

@section('buttons')
    <a href="{{ route('student-ticket.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>學生抽獎編號管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('student-ticket.update', $studentTicket), ['model' => $studentTicket]) }}
            {{ bs()->formGroup(bs()->input('number', 'id')->disabled())->label('抽獎編號')->showAsRow() }}
            @include('student-ticket.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
