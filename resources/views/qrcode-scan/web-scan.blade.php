@extends('layouts.base')

@section('title', '條碼掃描')

@section('css')
    <link rel="stylesheet" href="{{ asset(mix('build-css/vue-qrcode-reader.css')) }}">
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <web-scan></web-scan>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset(mix('/build-js/web-scan.js')) }}"></script>
@endsection
