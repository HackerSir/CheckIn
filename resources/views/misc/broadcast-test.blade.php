@extends('layouts.base')

@section('title', 'Broadcast Test')

@section('main_content')
    <broadcast-test></broadcast-test>
@endsection

@section('js')
    <script src="{{ asset(mix('/build-js/broadcast-test.js')) }}"></script>
@endsection
