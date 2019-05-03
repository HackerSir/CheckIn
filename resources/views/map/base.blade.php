@extends('layouts.base')

@section('title', '攤位地圖')

@section('css')
    <style>
        @media (max-width: 576px) {
            body .container {
                padding-left: 0;
                padding-right: 0;
            }
        }
    </style>
@endsection

@section('buttons')
    <div class="btn-group" role="group">
        <a href="{{ route('clubs.map.static') }}"
           class="btn btn-secondary @if (Route::currentRouteName() == 'clubs.map.static') active @endif">靜態地圖</a>
        <a href="{{ route('clubs.map.google') }}"
           class="btn btn-secondary @if (Route::currentRouteName() == 'clubs.map.google') active @endif">Google Map</a>
    </div>
@endsection
