@extends('layouts.app')

@section('title', '統計')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>統計</h1>
            <div class="card">
                @foreach($data as $value)
                    <div class="card-body">
                        <h3>{{ $value['name'] }}</h3>
                        <dl class="row" style="font-size: 120%">
                            <dt class="col-4 col-md-3">總人數</dt>
                            <dd class="col-8 col-md-9">
                                {{ number_format($value['total']) }}
                                <div class="progress w-80">
                                    <div
                                        class="progress-bar bg-success d-flex align-items-center justify-content-center"
                                        role="progressbar"
                                        style="width: 100%;"
                                        aria-valuenow="100" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div>100%</div>
                                    </div>
                                </div>
                            </dd>
                            <dt class="col-4 col-md-3">參與人數</dt>
                            <dd class="col-8 col-md-9">{{ number_format($value['play']) }}</dd>
                            <dt class="col-4 col-md-3 text-right text-muted">
                                <small>佔總人數：</small>
                            </dt>
                            <dd class="col-8 col-md-9">
                                <div class="progress w-80">
                                    <div class="progress-bar d-flex align-items-center justify-content-center"
                                         role="progressbar"
                                         style="width: {{ $value['play_percent'] }}%; min-width: 3rem;"
                                         aria-valuenow="{{ $value['play_percent'] }}" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div>{{ $value['play_percent'] }}%</div>
                                    </div>
                                </div>
                            </dd>
                            <dt class="col-4 col-md-3">完成任務</dt>
                            <dd class="col-8 col-md-9">{{ number_format($value['finish']) }}</dd>
                            <dt class="col-4 col-md-3 text-right text-muted">
                                <small>佔總人數：</small>
                            </dt>
                            <dd class="col-8 col-md-9">
                                <div class="progress w-80">
                                    <div
                                        class="progress-bar bg-success d-flex align-items-center justify-content-center"
                                        role="progressbar"
                                        style="width: {{ $value['finish_percent'] }}%; min-width: 3rem;"
                                        aria-valuenow="{{ $value['finish_percent'] }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div>{{ $value['finish_percent'] }}%</div>
                                    </div>
                                </div>
                            </dd>
                            <dt class="col-4 col-md-3 text-right text-muted">
                                <small>佔參與人數：</small>
                            </dt>
                            <dd class="col-8 col-md-9">
                                <div class="progress w-80">
                                    <div class="progress-bar d-flex align-items-center justify-content-center"
                                         role="progressbar"
                                         style="width: {{ $value['finish_play_percent'] }}%; min-width: 3rem;"
                                         aria-valuenow="{{ $value['finish_play_percent'] }}" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div>{{ $value['finish_play_percent'] }}%</div>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </div>
                @endforeach
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    註：
                    <ul>
                        <li>總人數：曾登入此系統，或NID曾出現於此系統之人數。</li>
                        <li>參與人數：打卡至少一次之人數。</li>
                        <li>完成任務：打卡次數達到目標（也就是{{ Setting::get('target') }}次(含)以上）的人數</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
