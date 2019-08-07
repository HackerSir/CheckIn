@extends('layouts.base')

@section('title', $paymentRecord->club->name . ' - ' . $paymentRecord->nid . ' - 繳費紀錄')

@section('buttons')
    <a href="{{ route('payment-record.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>繳費紀錄管理
    </a>
    <a href="{{ route('payment-record.edit', $paymentRecord) }}" class="btn btn-primary">
        <i class="fa fa-edit mr-2"></i>編輯
    </a>
    {!! Form::open(['route' => ['payment-record.destroy', $paymentRecord], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-trash mr-2"></i>刪除
    </button>
    {!! Form::close() !!}
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-2">社團</dt>
                <dd class="col-8 col-md-10">
                    <a href="{{ route('clubs.show', $paymentRecord->club) }}">{!! $paymentRecord->club->display_name !!}</a>
                </dd>

                <dt class="col-4 col-md-2">NID</dt>
                <dd class="col-8 col-md-10">{{ $paymentRecord->name }}</dd>

                <dt class="col-4 col-md-2">繳費狀況</dt>
                <dd class="col-8 col-md-10">{{ $paymentRecord->is_paid ? '已繳清' : '未繳清' }}</dd>

                <dt class="col-4 col-md-2">經手人</dt>
                <dd class="col-8 col-md-10">{{ $paymentRecord->handler }}</dd>

                <dt class="col-4 col-md-2">備註</dt>
                <dd class="col-8 col-md-10">{{ $paymentRecord->note }}</dd>

                <dt class="col-4 col-md-2">操作者</dt>
                <dd class="col-8 col-md-10">{{ $paymentRecord->user->display_name ?? null }}</dd>

                <dt class="col-4 col-md-2">更新時間</dt>
                <dd class="col-8 col-md-10">{{ $paymentRecord->updated_at }}</dd>
            </dl>
        </div>
    </div>
@endsection
