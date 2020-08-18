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
    <div class="jumbotron text-center pb-0">
        <h1 class="font-weight-bold">{{ config('app.cht_name') }}</h1>
        <svg viewBox="0 0 400 40" style="max-width: 400px">
            <text x="50%" y="20" text-anchor="middle" alignment-baseline="middle" font-size="1.75rem" font-weight="500">2020 逢甲社團博覽會集點打卡</text>
        </svg>
        <div></div>
        <svg viewBox="0 0 320 40" fill="#007bff" style="max-width: 320px; margin-top: 30px">
            <text x="50%" y="20" text-anchor="middle" alignment-baseline="middle" font-size="1.5rem">⬇ 點擊下方區塊開始使用 ⬇</text>
        </svg>
    </div>
    <div class="row mt-3 pb-3">
        <div class="col-md-6 col-lg-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('my-qrcode') }}">
                <div class="card-body">
                    <i class="fas fa-qrcode fa-10x fa-fw mb-1"></i>
                    <h4 class="card-title">快速打卡</h4>
                    <p class="card-text">使用 QR Code 加快打卡</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('my-qrcode') }}">
                <div class="card-body">
                    <i class="fas fa-th-large fa-10x fa-fw mb-1"></i>
                    <h4 class="card-title">即時集點進度</h4>
                    <p class="card-text">隨時查詢進度</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('clubs.index') }}">
                <div class="card-body">
                    <i class="fas fa-users fa-10x fa-fw mb-1"></i>
                    <h4 class="card-title">尋找社團</h4>
                    <p class="card-text">尋找你感興趣的社團</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('clubs.map.static') }}">
                <div class="card-body">
                    <i class="fas fa-map-marked-alt fa-10x fa-fw mb-1"></i>
                    <h4 class="card-title">攤位地圖</h4>
                    <p class="card-text">暢遊社博不迷路</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="card text-center btn btn-outline-primary" href="{{ route('faq') }}">
                <div class="card-body">
                    <i class="fas fa-question-circle fa-10x fa-fw mb-1"></i>
                    <h4 class="card-title">常見問題</h4>
                    <p class="card-text">解答您的疑惑</p>
                </div>
            </a>
        </div>
    </div>
@endsection
