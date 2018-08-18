@extends('layouts.app')

@section('content')
    <div class="mt-3 pb-3">
        <div>
            @yield('buttons')
        </div>
        <h1>@yield('title')</h1>
        <div class="mt-1 mb-3">
            @yield('main_content')
        </div>
    </div>
@endsection
