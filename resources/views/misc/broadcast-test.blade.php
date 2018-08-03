@extends('layouts.base')

@section('title', 'Broadcast Test')

@section('main_content')
    <broadcast-test></broadcast-test>
@endsection

@section('js')
    <script>
        window.Laravel.api = {
            message: '{{ route('broadcast-test.message') }}'
        };
    </script>
    <script src="{{ asset(mix('/build-js/broadcast-test.js')) }}"></script>
@endsection
