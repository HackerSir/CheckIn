@extends('map.base')

@section('title', '靜態地圖 - 攤位地圖')

@section('main_content')
    <div class="mt-2">
        <a href="{{ asset('img/static/static_map_1.png') }}" target="_blank">
            <img src="{{ asset('img/static/static_map_1.png') }}" class="img-fluid w-100" alt="static map">
        </a>
    </div>
@endsection
