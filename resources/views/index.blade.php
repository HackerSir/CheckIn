@extends('layouts.app')

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

        a.card.btn-outline-primary {
            color: black;
        }

        a.card.btn-outline-primary:hover {
            color: white;
        }
    </style>
@endsection
@section('content')
    @if(auth()->user() && !auth()->user()->student)
        <div class="alert alert-warning mt-3" role="alert">
            <strong>抱歉！</strong>雖然您已使用NID順利登入，但由於您並非本學期在校生，故無法參與集點活動。
        </div>
    @endif
    <div class="jumbotron">
        <h1 class="font-weight-bold">{{ config('app.cht_name') }}</h1>
        <h3>2019 逢甲社團博覽會集點打卡</h3>
        <div class="h4 text-center text-primary text-nowrap" style="margin-top: 2rem">
            <i class="fas fa-arrow-down mx-2"></i>點擊下方區塊開始使用<i class="fas fa-arrow-down mx-2"></i>
        </div>
    </div>
    <div class="row mt-3 pb-3">
        <div class="col-md-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('my-qrcode') }}">
                <div class="card-body">
                    <i class="fa fa-qrcode fa-10x fa-fw mb-1" aria-hidden="true"></i>
                    <h4 class="card-title">快速打卡</h4>
                    <p class="card-text">使用 QR Code 加快打卡</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('my-qrcode') }}">
                <div class="card-body">
                    <i class="fa fa-th-large fa-10x fa-fw mb-1" aria-hidden="true"></i>
                    <h4 class="card-title">即時集點進度</h4>
                    <p class="card-text">隨時查詢進度</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('clubs.index') }}">
                <div class="card-body">
                    <i class="fa fa-users fa-10x fa-fw mb-1" aria-hidden="true"></i>
                    <h4 class="card-title">尋找社團</h4>
                    <p class="card-text">尋找你感興趣的社團</p>
                </div>
            </a>
        </div>
    </div>
@endsection
