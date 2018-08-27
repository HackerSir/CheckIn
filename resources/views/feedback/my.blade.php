@extends('layouts.base')

@section('title', '我的回饋資料')

@section('buttons')
    @if($user->club)
        <a href="{{ route('feedback.index') }}" class="btn btn-secondary">
            <i class="far fa-comments"></i> 回饋資料管理
        </a>
    @endif
@endsection

@section('main_content')
    @include('feedback.time-range')
    <my-feedback-list></my-feedback-list>
@endsection

@section('js')
    <script src="{{ asset(mix('/build-js/vue.js')) }}"></script>
@endsection
