@extends('layouts.app')

@section('title', $student->name . ' - 學生')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    QR Code
                </div>
                <div class="card-block text-center">
                    <p>於攤位打卡時，請出示此條碼</p>
                    <img src="{{ route('code-picture.qrcode', $student->qrcode->code) }}" class="img-fluid">
                    <p>{{ $student->qrcode->code }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    基本資料
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">NID：</td>
                            <td>{{ $student->nid }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">姓名：</td>
                            <td>{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">進度：</td>
                            <td>{{ $student->countedRecords->count() }}
                                / {{ \Setting::get('target') }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">抽獎編號：</td>
                            <td>{{ $student->ticket->id ?? '尚未取得' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @include('components.record-list', ['records' => $student->records])
        </div>
    </div>
@endsection
