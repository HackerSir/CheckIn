@extends('layouts.base')

@section('title', '社團攤位')

@section('main_content')
    <div class="card">
        <div class="card-body">
            <club-cards></club-cards>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
    <script src="{{ asset(mix('/build-js/vue.js')) }}"></script>
@endsection
