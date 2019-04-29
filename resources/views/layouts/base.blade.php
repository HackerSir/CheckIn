@extends('layouts.app')

@section('content')
    <div class="mt-3 pb-3">
        <h1>@yield('title')</h1>
        <div>
            @yield('buttons')
        </div>
        <div class="mt-1 mb-3">
            @yield('main_content')
        </div>
    </div>
@endsection
