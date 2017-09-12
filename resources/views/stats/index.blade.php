@extends('layouts.app')

@section('title', '統計')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>統計</h1>
            <div class="card">
                @foreach($data as $value)
                    <div class="card-block">
                        <h3>{{ $value['name'] }}</h3>
                        <dl class="row" style="font-size: 120%">
                            <dt class="col-4 col-md-2">總人數</dt>
                            <dd class="col-8 col-md-10">
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
                            <dt class="col-4 col-md-2">參與人數</dt>
                            <dd class="col-8 col-md-10">
                                {{ number_format($value['play']) }}
                                <div class="progress w-80">
                                    <div class="progress-bar d-flex align-items-center justify-content-center"
                                         role="progressbar"
                                         style="width: {{ $value['play_percent'] }}%;"
                                         aria-valuenow="{{ $value['play_percent'] }}" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div>{{ $value['play_percent'] }}%</div>
                                    </div>
                                </div>
                            </dd>
                            <dt class="col-4 col-md-2">完成任務</dt>
                            <dd class="col-8 col-md-10">
                                {{ number_format($value['finish']) }}
                                <div class="progress w-80">
                                    <div
                                        class="progress-bar bg-success d-flex align-items-center justify-content-center"
                                        role="progressbar"
                                        style="width: {{ $value['finish_percent'] }}%;"
                                        aria-valuenow="{{ $value['finish_percent'] }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <div>{{ $value['finish_percent'] }}%</div>
                                    </div>
                                </div>
                                <div class="progress w-80">
                                    <div class="progress-bar d-flex align-items-center justify-content-center"
                                         role="progressbar"
                                         style="width: {{ $value['finish_play_percent'] }}%;"
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
        </div>
    </div>
@endsection
