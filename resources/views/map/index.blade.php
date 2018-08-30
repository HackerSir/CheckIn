@extends('layouts.base')

@section('title', '攤位地圖')

@section('css')
    <style>
        #map {
            width: 100%;
            height: 70vh;
        }

        @media (max-width: 576px) {
            body > .container {
                padding-left: 0;
                padding-right: 0;
            }
        }

        a {
            cursor: pointer;
        }
    </style>
@endsection

@section('buttons')
    <div class="btn-group" role="group">
        <a href="{{ route('clubs.map', ['type' => 'static']) }}"
           class="btn btn-secondary @if ($type == 'static') active @endif">靜態地圖</a>
        <a href="{{ route('clubs.map', ['type' => 'google']) }}"
           class="btn btn-secondary @if ($type == 'google') active @endif">Google Map</a>
    </div>
@endsection

@section('main_content')
    @if ($type == 'static')
        @include('map.static')
    @elseif ($type == 'google')
        @include('map.google')
    @endif
@endsection
