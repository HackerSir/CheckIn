@extends('layouts.app')

@section('title', '社團清單')

@section('content')
    <div class="mt-3 pb-3">
        <div class="card">
            <div class="card-body">
                <h1>社團攤位</h1>
                <club-cards></club-cards>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
    <script src="{{ asset(mix('/build-js/vue.js')) }}"></script>
@endsection
