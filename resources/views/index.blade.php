@extends('layouts.app')

@section('title', '首頁')

@section('css')
    <style>
        #main_jumbotron {
            word-break: break-all;
            margin-bottom: 0;
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <div id="main_jumbotron" class="jumbotron mt-3">
        <h1 class="display-2">{{ config('app.cht_name') }}</h1>
        <h2>2017 逢甲社團博覽會集點打卡</h2>
        <a href="{{ route('oauth.index') }}" class="btn btn-primary btn-lg" title="Let's GO!!">GO!</a>
    </div>
@endsection
