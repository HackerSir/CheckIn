@extends('layouts.app')

@section('title', '首頁')

@section('css')
    <style>
        .jumbotron {
            word-break: break-all;
            margin-bottom: 0;
            border-radius: 20px;
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .card {
            border-radius: 20px;
            margin-bottom: 2rem;
        }

        .fa.fa-10x {
            font-size: 10em;
        }
    </style>
@endsection
@section('content')
    @if(auth()->user() && !auth()->user()->is_local_account && !auth()->user()->student)
        <div class="alert alert-warning mt-3" role="alert">
            <strong>抱歉！</strong>雖然您已使用NID順利登入，但由於您並非本學期大學部在校生，因此無法參與集點活動。
        </div>
    @endif
    <div class="jumbotron mt-3">
        <h1>{{ config('app.cht_name') }}</h1>
        <h3>2017 逢甲社團博覽會集點打卡</h3>
        <a href="{{ route('oauth.index') }}" class="btn btn-primary btn-lg" title="Let's GO!!">GO!</a>
    </div>
    <div class="row mt-3 pb-3">
        <div class="col">
            <div class="card text-center">
                <div class="card-block">
                    <i class="fa fa-qrcode fa-10x mb-1" aria-hidden="true"></i>
                    <h4 class="card-title">快速打卡</h4>
                    <p class="card-text">使用 QR Code 加快打卡</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center">
                <div class="card-block">
                    <i class="fa fa-th-large fa-10x mb-1" aria-hidden="true"></i>
                    <h4 class="card-title">即時集點進度</h4>
                    <p class="card-text">隨時查詢進度</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center">
                <div class="card-block">
                    <i class="fa fa-users fa-10x mb-1" aria-hidden="true"></i>
                    <h4 class="card-title">尋找社團</h4>
                    <p class="card-text">尋找你感興趣的社團</p>
                </div>
            </div>
        </div>
    </div>
@endsection
