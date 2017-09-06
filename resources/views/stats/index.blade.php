@extends('layouts.app')

@section('title', '統計')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>統計</h1>
            <div class="card">
                <div class="card-block">
                    <h3>總人數</h3>
                    <p style="font-size: 120%">{{ number_format($count['total']) }}</p>
                </div>
                <div class="card-block">
                    <h3>參與人數</h3>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">新生</dt>
                        <dd class="col-8 col-md-10">{{ number_format($count['play']['freshman']) }}</dd>
                        <dt class="col-4 col-md-2">非新生</dt>
                        <dd class="col-8 col-md-10">{{ number_format($count['play']['non_freshman']) }}</dd>
                    </dl>
                </div>
                <div class="card-block">
                    <h3>任務完成人數</h3>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-4 col-md-2">新生</dt>
                        <dd class="col-8 col-md-10">{{ number_format($count['finish']['freshman']) }}</dd>
                        <dt class="col-4 col-md-2">非新生</dt>
                        <dd class="col-8 col-md-10">{{ number_format($count['finish']['non_freshman']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
