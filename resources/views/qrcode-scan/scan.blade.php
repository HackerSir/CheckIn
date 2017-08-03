@extends('layouts.app')

@section('title', '條碼掃描')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>條碼掃描</h1>
            @if(isset($message))
                <div class="alert alert-{{ $level ?? 'info' }}" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    基本資訊
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">條碼：</td>
                            <td>{{ $code }}</td>
                        </tr>
                        @if(isset($qrcode))
                            @if($qrcode->student)
                                <tr>
                                    <td class="text-md-right">學生：</td>
                                    <td>{{ $qrcode->student->masked_display_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-md-right">進度：</td>
                                    <td>{{ $qrcode->student->countedRecords->count() }}
                                        / {{ \Setting::get('target') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-md-right">抽獎編號：</td>
                                    <td>{{ $qrcode->student->ticket->id ?? '尚未取得' }}</td>
                                </tr>
                            @endif
                        @endif
                    </table>
                </div>
            </div>
            @if(isset($qrcode->student))
                @include('components.record-list', ['records' => $qrcode->student->records])
            @endif
        </div>
    </div>
@endsection
