@extends('layouts.app')

@section('title', $student->name . ' - 學生')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('student.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生管理
            </a>
            <h1>{{ $student->name }} - 學生</h1>
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
                            <td class="text-md-right">班級：</td>
                            <td>{{ $student->class }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">科系：</td>
                            <td>{{ $student->unit_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">學院：</td>
                            <td>{{ $student->dept_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">入學年度：</td>
                            <td>{{ $student->in_year }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">性別：</td>
                            <td>{{ $student->gender }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    打卡進度
                </div>
                <div class="card-block">
                    <table class="table table-hover">
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
            <div class="card">
                <div class="card-header">
                    QR Code
                </div>
                <div class="card-block">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>代碼</th>
                            <th>綁定時間</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($student->qrcodes as $qrcode)
                            <tr>
                                <td>
                                    {{ $qrcode->code }}
                                    @if($qrcode->is_last_one)
                                        <i class="fa fa-check text-success" aria-hidden="true" title="最後一組"></i>
                                    @endif
                                </td>
                                <td>
                                    {{ $qrcode->bind_at }}
                                    （{{ $qrcode->bind_at->diffForHumans() }}）
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    暫無
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @include('components.record-list', ['records' => $student->records])
        </div>
    </div>
@endsection
