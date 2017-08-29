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
                <div class="card-block">
                    <h1>基本資料</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">學號(NID)</dt>
                        <dd class="col-8 col-md-10">{{ $student->nid }}</dd>

                        <dt class="col-4 col-md-2">姓名</dt>
                        <dd class="col-8 col-md-10">{{ $student->name }}</dd>

                        <dt class="col-4 col-md-2">班級</dt>
                        <dd class="col-8 col-md-10">{{ $student->class }}</dd>

                        <dt class="col-4 col-md-2">科系</dt>
                        <dd class="col-8 col-md-10">{{ $student->unit_name }}</dd>

                        <dt class="col-4 col-md-2">學院</dt>
                        <dd class="col-8 col-md-10">{{ $student->dept_name }}</dd>

                        <dt class="col-4 col-md-2">入學年度</dt>
                        <dd class="col-8 col-md-10">{{ $student->in_year }}</dd>

                        <dt class="col-4 col-md-2">性別</dt>
                        <dd class="col-8 col-md-10">{{ $student->gender }}</dd>

                        <dt class="col-4 col-md-2">新生</dt>
                        <dd class="col-8 col-md-10">
                            @if($student->is_freshman)
                                <i class="fa fa-check fa-2x text-success" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-times fa-2x text-danger" aria-hidden="true"></i>
                            @endif
                        </dd>

                        @if($student->user && Laratrust::can('user.manage'))
                            <dt class="col-4 col-md-2">使用者</dt>
                            <dd class="col-8 col-md-10">
                                {{ link_to_route('user.show', $student->user->name, $student->user) }}
                            </dd>
                        @endif
                    </dl>

                    <hr/>

                    <h1>集點任務</h1>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">打卡次數</dt>
                        <dd class="col-8 col-md-10">{{ $student->records->count() }}</dd>

                        <dt class="col-4 col-md-2">進度</dt>
                        <dd class="col-8 col-md-10">{{ $student->countedRecords->count() }}
                            / {{ \Setting::get('target') }}</dd>
                    </dl>
                    <div class="progress w-80">
                        @php
                            $progress = ($student->countedRecords->count() / \Setting::get('target')) * 100;
                            $progress = round($progress, 2);
                        @endphp
                        <div class="progress-bar d-flex align-items-center justify-content-center"
                             role="progressbar"
                             style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0"
                             aria-valuemax="100">
                            <div>{{ $progress }}%</div>
                        </div>
                    </div>

                    <hr/>

                    <h1>抽獎編號</h1>
                    <div class="text-center">
                        @if(isset($student->ticket))
                            <h3 class="text-danger">{{ sprintf("%04d", $student->ticket->id) }}</h3>
                        @else
                            <h3 class="text-danger">集點任務尚未完成</h3>
                        @endif
                    </div>

                    <hr/>

                    <h1>QR Code</h1>

                    <table class="table table-hover table-bordered">
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
                                    @if(Laratrust::can('qrcode.manage'))
                                        {{ link_to_route('qrcode.show', $qrcode->code, $qrcode) }}
                                    @else
                                        {{ $qrcode->code }}
                                    @endif
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

                    <hr/>

                    <h1>打卡紀錄</h1>
                    @include('components.record-list', ['records' => $student->records])
                </div>
            </div>
        </div>
    </div>
@endsection
