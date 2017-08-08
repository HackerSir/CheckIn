@extends('layouts.app')

@section('title', '給' . $feedback->club->name . '的回饋資料')

@section('css')
    <style>
        table tr td:first-child {
            white-space: nowrap
        }
    </style>
@endsection

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('feedback.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 回饋資料
            </a>
            <h1>給{{ $feedback->club->name }}的回饋資料</h1>
            <div class="card">
                <div class="card-header">
                    基本資料
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">學生：</td>
                            <td>{{ $feedback->student->display_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">新生：</td>
                            <td>
                                @if($feedback->student->is_freshman)
                                    <i class="fa fa-check fa-fw fa-2x text-success" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-times fa-fw fa-2x text-danger" aria-hidden="true"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">社團：</td>
                            <td>
                                {!! $feedback->club->clubType->tag ?? '' !!}
                                {{ $feedback->club->name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">打卡時間：</td>
                            <td>
                                @if($record)
                                    <i class="fa fa-check fa-fw fa-2x text-success" aria-hidden="true"></i>
                                    {{ $record->created_at }}
                                    （{{ $record->created_at->diffForHumans() }}）
                                @else
                                    <i class="fa fa-times fa-fw fa-2x text-danger" aria-hidden="true"></i>
                                    尚未打卡
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-header">
                    回饋資料
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">電話：</td>
                            <td>{{ $feedback->phone }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">信箱：</td>
                            <td>{{ $feedback->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">訊息：</td>
                            <td>{{ $feedback->message }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
