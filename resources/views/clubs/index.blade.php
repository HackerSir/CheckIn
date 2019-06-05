@extends('layouts.base')

@section('title', !$favoriteOnly ? '社團攤位' : '收藏社團')

@section('meta')
    <meta name="club-last-updated-at" content="{{ $clubLastUpdatedAt }}">
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <club-cards favorite-only="{{ $favoriteOnly }}"></club-cards>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset(mix('/build-js/vue.js')) }}"></script>
@endsection
